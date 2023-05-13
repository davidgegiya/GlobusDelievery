<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestaurantsController extends Controller
{
    function showAll(){
        return Inertia::render('Restaurants', ['restaurants' => Restaurant::whereNotNull('id')->orderBy('name', 'asc')->get()]);
    }

    function search(Request $request){
        $data = $request->only(['search', 'sort', 'sortType']);
        $name = $data['search'];
        $sort = $data['sort'];
        $sortType = $data['sortType'];
        if (!$data){
            return Inertia::render('Restaurants', ['restaurants' => Restaurant::whereNotNull('id')->orderBy($sort, $sortType)->get()]);
        }
        return Inertia::render('Restaurants', ['restaurants' => Restaurant::where('name', 'like', '%'.$name.'%')->orderBy($sort, $sortType)->get()]);
    }
}
