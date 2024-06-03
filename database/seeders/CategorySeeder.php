<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            [
            'name'=>'Starup',
                'icons'=>null
            ],
            [
                'name'=>'Movies',
                'icons'=>null
            ],
            [
                'name'=>'Business',
                'icons'=>null
            ],
            [
                'name'=>'Learning',
                'icons'=>null
            ],
            [
                'name'=>'Game',
                'icons'=>null
            ],
            [
                'name'=>'Sport',
                'icons'=>null
            ]
            ];
            // insert data
            foreach($categories as $category){
                Category::create([
                    'name'=>$category['name'],
                    'icons'=>$category['icons'],
                ]);
            }
    }
}
