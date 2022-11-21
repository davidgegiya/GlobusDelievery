@extends('layouts.app')

@section('docname', 'Profile')

@section('content')
    <div class="margin" style="margin-top: 2em">
        <h1 style="background-color: lightgray; margin-bottom: 1em">Список заказов</h1>
    @foreach($user->orders->sortByDesc('updated_at') as $order)
            <div class="col-sm-6" id="{{ $order->id }}">
                <div class="card text-center mx-auto" style="padding:20px; max-width:400px; margin-bottom: 3em">
                    <a class="card-link" href="{{ route('user.viewOrder', $order->id) }}">
                        <img src="{{ $order->order_items[0]->meal->image }}" class="card-img-top mx-auto" style="width:300px;"
                             alt="">
                        <div class="card-body">
                            <h5 class="card-title">Заказ от {{ $order->updated_at }}</h5>
                        </div>
                    </a>
                    <div class="card-footer">
                        <div class="row" style="display: flex; flex-direction: row">
                            <div class="price-total-group col-5">
                                <span id="{{ $order->id }}t"> На сумму: {{ $order->total_price }} ₽ </span>
                            </div>
                            <div class="status-group col-5">
                                <span id="{{ $order->id }}s"> Статус: {{ $order->status }} </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
@endsection
