@extends('layouts.app')

@section('docname', 'Cart')

@section('content')
    <div class="margin" style="margin-top: 2em">
        <h1 style="background-color: lightgray; margin-bottom: 1em">Корзина</h1>
        @if($user && $order_items)
            @if(count($order_items))
                <h3 style="background-color: lightgray; margin-bottom: 1em" id="total-price"> В корзине товаров
                    на {{ $current_order->total_price }} ₽</h3>
                @foreach($order_items as $order_item)
                    <div class="col-sm-6" id="{{ $order_item->id }}">
                        @php
                            $total = $order_item->meal->price * $order_item->count;
                        @endphp
                        <div class="card text-center mx-auto" style="padding:20px; max-width:400px; margin-bottom: 3em">
                            <div class="btn-group" style="display: flex; justify-content: end; margin-bottom: 1em">
                                <button class="btn btn-danger" style="max-width: 3em"
                                        onclick="deleteFromDB('{{ $order_item->id }}')"><i
                                        class="bi bi-trash3-fill"></i>
                                </button>
                            </div>
                            <a class="card-link"
                               href="{{ route('user.restContent', $order_item->meal->restaurant->name) }}">
                                <img src="{{ $order_item->meal->image }}" class="card-img-top mx-auto"
                                     style="width:300px;"
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
                                    <div class="price-per-one-group col-4">
                                        <span> {{ $order_item->meal->price }} ₽ </span>
                                    </div>
                                    <div class="price-total-group col-5">
                                        <span id="{{ $order_item->id }}t"> Итого: {{ $total }} ₽ </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="set-count-group row d-flex align-items-center justify-content-center"
                                style="padding: 0.5em;" id="{{ $order_item->meal->id }}">
                                <button class="btn btn-secondary col"
                                        onclick="decrease('{{ $order_item->meal->id }}', '{{$order_item->id}}', '{{ $order_item->meal->price }}')">
                                    <i class="bi bi-dash-square"></i>
                                </button>
                                <div class="container col">
                                    <span>{{ $order_item->count }}</span>
                                </div>
                                <button class="btn btn-secondary col"
                                        onclick="increase('{{ $order_item->meal->id }}', '{{$order_item->id}}', '{{ $order_item->meal->price }}')">
                                    <i class="bi bi-plus-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <a href="{{ route('user.placeOrder') }}">
                    <button class="btn btn-success" style="margin-bottom: 2em">Оформить заказ</button>
                </a>
            @endif
        @else
            <h1>В корзине ничего нет :(</h1>
        @endif
    </div>
    <script>
        let updateInfo = (id, count, price) => {
            console.log(price);
            console.log(count);
            $('#' + id + 'c').html('X ' + count);
            $('#' + id + 't').html('Итого: ' + price * count + '₽');
        }

        let updateTotalPrice = (price) => {
            $('#total-price').html('В корзине товаров на ' + price + '₽');
        }

        let deleteFromDB = (id) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route('user.removeFromCart') }}',
                data: {
                    'id': id,
                },
                datatype: 'json',
                success: function (data) {
                    if (!data.errors) {

                        deleteItem(id);
                        @if($current_order)
                        getOrder('{{ $current_order->id }}').then(
                            (e) => {
                                updateTotalPrice(e);
                            }
                        )
                        @endif
                    }
                },
            });
        }

        let deleteItem = (id) => {
            $('#' + id).replaceWith('<div></div>');
        }

        let getOrder = (id) => {
            return new Promise(function (resolve, reject) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: '{{ route('user.getOrder') }}',
                    data: {
                        'id': id,
                    },
                    datatype: 'json',
                    success: function (data) {
                        if (!data.errors) {
                            resolve(data.total_price);
                        }
                    },
                });
            });
        }

        let increase = (id, order_item_id, meal_price) => {
            console.log(id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route('user.increase') }}',
                data: {
                    'id': id,
                },
                datatype: 'json',
                success: function (data) {
                    if (!data.errors) {
                        let count = document.getElementById(id).querySelector("div");
                        count = count.querySelector("span").innerHTML;
                        count = +count;
                        count += 1;
                        getOrder(data.id).then((price) => {
                            $('#' + id).children("div").replaceWith("                                                    <div class=\"container col\" id=" + id + ">\n                                                        <span>" + count + "</span>\n                                                    </div>");
                            updateTotalPrice(price);
                            updateInfo(order_item_id, count, meal_price);
                        });
                    }
                },
            });
        }

        let decrease = (id, order_item_id, meal_price) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route('user.decrease') }}',
                data: {
                    'id': id,
                },
                datatype: 'json',
                success: function (data) {
                    if (!data.errors) {
                        // $('#inc-temp').replaceWith(data);
                        let count = document.getElementById(id).querySelector("div");
                        count = count.querySelector("span").innerHTML;
                        count = +count;
                        if (count == 1) {
                            deleteItem(order_item_id);
                        } else {
                            count -= 1;
                            $('#' + id).children("div").replaceWith("                                                    <div class=\"container col\" id=" + id + ">\n                                                        <span>" + count + "</span>\n                                                    </div>");
                            getOrder(data.id).then((price) => {
                                updateTotalPrice(price);
                                updateInfo(order_item_id, count, meal_price);
                            });
                        }
                    }
                },
            });
        }
    </script>
@endsection
