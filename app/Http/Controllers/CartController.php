<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    function cart(){
        return Inertia::render('Cart');
    }

}
