@extends('layouts.app')

@section('docname', 'Order ' . $order->id)

@section('content')
    <div class="margin" style="margin-top: 2em">
        <h1 style="background-color: lightgray; margin-bottom: 1em">Заказ от {{ $order->updated_at }}</h1>
        <h3 style="background-color: lightgray; margin-bottom: 1em" id="total-price"> Заказ на
            на {{ $order->total_price }} ₽</h3>
        @foreach($order->order_items as $order_item)
            <div class="col-sm-6" id="{{ $order_item->id }}">
                @php
                    $total = $order_item->meal->price * $order_item->count;
                @endphp
                <div class="card text-center mx-auto" style="padding:20px; max-width:400px; margin-bottom: 3em">
                    <a class="card-link" href="{{ route('user.restContent', $order_item->meal->restaurant->name) }}">
                        <img src="{{ $order_item->meal->image }}" class="card-img-top mx-auto" style="width:300px;"
                             alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{ $order_item->meal->name }}</h5>
                        </div>
                    </a>
                    <div class="card-footer">
                        <div class="row" style="display: flex; flex-direction: row">
                            <div class="count-group col-3">
                                <span id="{{ $order_item->id }}c">X {{ $order_item->count }}</span>
                            </div>
                            <div class="price-per-one-group">
                                <span> {{ $order_item->meal->price }} ₽ </span>
                            </div>
                            <div class="price-total-group">
                                <span id="{{ $order_item->id }}t"> Итого: {{ $total }} ₽ </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
