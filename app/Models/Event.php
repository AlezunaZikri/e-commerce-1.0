<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Event extends Model
{
    use HasFactory, SoftDeletes;
    
    // relation to tickets
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    protected $fillable = [
        'name',
        'slug',
        'headline',
        'description',
        'start_time',
        'location',
        'duration',
        'is_populer',
        'photos',
        'category_id',
        'type',   
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'photos' => 'array',
    ];

    // relation to categories
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    
    // Get the lowest price ticket for the event.
    public function getStartFromAttribute()
    {
        $lowestTicket = $this->tickets()->orderBy('price')->first();
        return $lowestTicket ? $lowestTicket->price : null;
    }

     
    // Get the first photo as a thumbnail from the photos attribute, if not exist return default image. 
    public function getThumbnailAttribute()
    {
        $photos = $this->photos;

        if ($photos && !empty($photos)) {
            return Storage::url($photos[0]);
        }

        return asset('assets/images/event-1.webp');
    }

    
    // Scope a query to only include events with certain category.
    public function scopeWithCategory($query, $category)
    {
        return $query->where('category_id', $category);
    }
    
    // Scope a query to only include upcoming events.
    public function scopeUpcoming($query)
    {
        return $query->orderBy('start_time', 'asc')->where('start_time', '>=', now());
    }

    // Scope a query to find event by slug.
    public function scopeFetch($query, $slug)
    {
        return $query->with(['category', 'tickets'])
            ->withCount('tickets')
            ->where('slug', $slug)
            ->firstOrFail();
    }

}
