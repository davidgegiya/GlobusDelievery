<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function cart(){
        return view('user.basket');
    }

    function cartRestLink(Request $request){
        $meal = Meal::where('id', '=', $request->meal_id)->get();
        $rest = Restaurant::where('id', '=', $meal->restaurant_id)->get();
        return redirect(route('user.restContent', $rest->id));
    }
}
