<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealCategoriesController extends Controller
{

    function showAll($name, Request $request)
    {
        $catList = Category::where('restaurant_name', '=', $name)->get();
        $mealList = [];
        foreach ($catList as $cat) {
            $cat->meals = Meal::where('category_id', '=', $cat->id)->get();
        }
        return Inertia::render('RestContent', ['categories' => $catList, 'rest_name' => $name]);
    }
}
