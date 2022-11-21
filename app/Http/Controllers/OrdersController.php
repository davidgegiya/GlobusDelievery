<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    function viewOrder(Request $request){
        $order = Order::where('id', '=', $request->id)->get()[0];
        return view('user.order_info', ['order' => $order]);
    }

    function placeOrder(){
        $user = Auth::user();
        $order = Order::where('id', '=', $user->current_order)->get()[0];
        $order->status = "processing";
        $order->save();
        $user->current_order=null;
        $user->save();
        return redirect(route('user.profile'));
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
        $order_item->meal_id = $request->id;
        $order_item->count = 1;
        $order_item->save();
        return response()->json($order);
    }

    function increase(Request $request){
        $user = Auth::user();
        $order = Order::where('id', '=', $user->current_order)->get()[0];
        $meal = Meal::where('id', '=', $request->id)->get()[0];
        $order_item = OrderItem::where('order_id', '=', $order->id)->where('meal_id', '=', $meal->id)->get()[0];
        $order_item->count += 1;
        $order_item->save();
        return response()->json($order);
    }

    function decrease(Request $request){
        $user = Auth::user();
        $order = Order::where('id', '=', $user->current_order)->get()[0];
        $meal = Meal::where('id', '=', $request->id)->get()[0];
        $order_item = OrderItem::where('order_id', '=', $order->id)->where('meal_id', '=', $meal->id)->get()[0];
        if($order_item->count != 1) {
            $order_item->count -= 1;
            $order_item->save();
        }
        else {
            $order_item->delete();
        }
        return response()->json($order);
    }

    function getOrder(Request $request){
        return response()->json(Order::where('id', '=', $request->id)->get()[0]);
    }

    function removeFromCart(Request $request){
        $order_item = OrderItem::where('id', '=', $request->id)->get()[0];
        $order = $order_item->order;
        $order->total_price -= ($order_item->count-1)*$order_item->meal->price;
        $order->save();
        $order_item->delete();
        return response("Success!");
    }
}
