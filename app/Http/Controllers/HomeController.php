<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = $this->fetchEvent();
        // dd($events);
        $categories = $this->fetchCategory();

        return view('frontend.index', compact('events','categories'));
    }

    // fetch data event
    private function fetchEvent(){
        $category = request()->query('caegory');
        $event = Event::upcoming();

        // limit event 6
        if(!request()->query('all_events')){
            $event->limit(6);
        }

        if($category){
            $event->withCategory();
        }

        return $event->get();
    }

    // fetch data category
    private function fetchCategory(){
        $categories = Category::sortByMostEvents();

        // limit category 4
        if(!request()->query('all_categories')){
            $categories->limit(4);
        }

        return $categories->get();
    }

}
