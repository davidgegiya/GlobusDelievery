<?php

namespace App\Http\Middleware;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $current_order = '';
        $order_items = '';
        if (Auth::check()) {
            $user = Auth::user();
            $current_order = $user->current_order ? Order::where('id', '=', $user->current_order)->get()[0] : null;
            $order_items = $current_order ? OrderItem::where('order_id', '=', $current_order->id)->get() : null;
            if($order_items) {
                foreach ($order_items as $order_item) {
                    $order_item->meal = Meal::where('id', '=', $order_item->meal_id)->first();
                }
            }
        }
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'current_order' => $current_order,
                'order_items' => $order_items
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
