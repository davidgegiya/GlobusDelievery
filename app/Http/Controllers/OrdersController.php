<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrdersController extends Controller
{
    function ordersList(Request $request){
        $orders = Order::where('user_id', '=', Auth::user()->id)->get();
        foreach ($orders as $order){
            $order->order_items = OrderItem::where('order_id', '=', $order->id)->get();
            foreach ($order->order_items as $order_item){
                $order_item->meal = Meal::where('id', '=', $order_item->meal_id)->first();
            }
        }
        return Inertia::render('OrdersList', ['orders' => $orders]);
    }

    function viewOrder(Request $request){
        $order = Order::where('id', '=', $request->id)->get()[0];
        $order_items = OrderItem::where('order_id', '=', $order->id)->get();
        foreach ($order_items as $order_item){
            $order_item->meal = Meal::where('id', '=', $order_item->meal_id)->first();
        }
        return Inertia::render('SingleOrder', ['order' => $order, 'order_items' => $order_items]);
    }

    function placeOrder(){
        $user = Auth::user();
        $order = Order::where('id', '=', $user->current_order)->get()[0];
        $order->status = "processing";
        $order->save();
        $user->current_order=null;
        $user->save();
        return redirect(route('rest_all'));
    }

    function addToCart(Request $request) {
        $user = Auth::user();
        $order = null;
        if (!$user->current_order){
            $order = new Order();
            $order->id = uniqid();
            $order->user_id = $user->id;
            $order->total_price=0;
            $order->status="in progress";
            $order->save();
            $user->current_order = $order->id;
            $user->save();
        }
        else{
            $order = Order::where('id', '=', $user->current_order)->get()[0];
        }

        $order_item = new OrderItem();
        $order_item->user_id = $user->id;
        $order_item->id = uniqid();
        $order_item->order_id = $order->id;
        $order_item->meal_id = $request->meal_id;
        $order_item->count = 1;
        $order_item->save();
    }

    function increase(Request $request){
        $user = Auth::user();
        $order = Order::where('id', '=', $user->current_order)->get()[0];
        $meal = Meal::where('id', '=', $request->meal_id)->get()[0];
        $order_item = OrderItem::where('order_id', '=', $order->id)->where('meal_id', '=', $meal->id)->get()[0];
        $order_item->count += 1;
        $order_item->save();
    }

    function decrease(Request $request){
        $user = Auth::user();
        $order = Order::where('id', '=', $user->current_order)->get()[0];
        $meal = Meal::where('id', '=', $request->meal_id)->get()[0];
        $order_item = OrderItem::where('order_id', '=', $order->id)->where('meal_id', '=', $meal->id)->get()[0];
        if($order_item->count != 1) {
            $order_item->count -= 1;
            $order_item->save();
        }
        else {
            $order_item->delete();
        }
    }

    function removeFromCart(Request $request){
        $order_item = OrderItem::where('id', '=', $request->meal_id)->get()[0];
        $order = $order_item->order;
        $order->total_price -= ($order_item->count-1)*$order_item->meal->price;
        $order->save();
        $order_item->delete();
    }
}
