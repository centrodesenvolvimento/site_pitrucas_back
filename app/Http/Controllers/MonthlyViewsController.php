<?php

namespace App\Http\Controllers;

use App\Models\MonthlyViews;
use Illuminate\Http\Request;

class MonthlyViewsController extends Controller
{
    public function all()
    {
        $views = MonthlyViews::all();


        return response()->json($views);
    }

    public function store(Request $request)
    {
        // Validate the incoming request


        // Create a new view record
        $view = MonthlyViews::create([
            'dateAdded' => $request->input('dateAdded'),
        ]);
        

        return response()->json($view);
    }
}
