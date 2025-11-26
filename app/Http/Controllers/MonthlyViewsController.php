<?php

namespace App\Http\Controllers;

use App\Models\MonthlyViews;
use App\Models\MonthlyViews1;
use Illuminate\Http\Request;

class MonthlyViewsController extends Controller
{
    public function all()
    {
        $views = MonthlyViews::all();


        return response()->json($views);
    }
    public function all1()
    {
        $views = MonthlyViews1::all();


        return response()->json($views);
    }

    public function store(Request $request)
    {
        // Validate the incoming request


        // Create a new view record
        $view = MonthlyViews::create([
            'dateAdded' => now(),
        ]);
        

        return response()->json($view);
    }
    public function store1(Request $request)
    {
        // Validate the incoming request


        // Create a new view record
        $view = MonthlyViews1::create([
            'dateAdded' => now(),
        ]);
        

        return response()->json($view);
    }
}
