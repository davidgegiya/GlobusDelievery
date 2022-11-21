<?php

namespace App\View\Composers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;

class UserComposer
{

    public function __construct()
    {
    }

    public function compose(ViewView $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $current_order = $user->current_order ? Order::where('id', '=', $user->current_order)->get()[0] : null;
            $order_items = $current_order ? OrderItem::where('order_id', '=', $current_order->id)->get() : null;
            $view->with('user', $user);
            $view->with('current_order', $current_order);
            $view->with('order_items', $order_items);
        }
        else{
            $view->with('user', null);
            $view->with('current_order', null);
            $view->with('order_items', null);
        }
    }
}
