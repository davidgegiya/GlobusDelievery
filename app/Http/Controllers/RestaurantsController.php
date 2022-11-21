<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantsController extends Controller
{
    function showAll(){
        return view('user.restaurants', ['restaurants' => Restaurant::whereNotNull('id')->orderBy('name', 'asc')->get()]);
    }

    function search(Request $request){
        $data = $request->only(['data', 'sort', 'sort-type']);
        $name = $data['data'];
        $sort = $data['sort'];
        $sortType = $data['sort-type'];
        if (!$data){
            return view('layouts.rest_list', ['restaurants' => Restaurant::whereNotNull('id')->orderBy($sort, $sortType)->get()]);
        }
        return view('layouts.rest_list', ['restaurants' => Restaurant::where('name', 'like', '%'.$name.'%')->orderBy($sort, $sortType)->get()]);
    }
}
