<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MealCategoriesController extends Controller
{

    function showAll($name, Request $request)
    {
        $catList = Category::where('restaurant_name', '=', $name)->get();
        $mealList = [];
        foreach ($catList as $cat) {
            array_push($mealList, Meal::where('category_id', '=', $cat->id)->get());
        }
        return view('user.rest_content', ['categories' => $catList, 'meals' => $mealList, 'rest_name' => $name]);
    }
}
