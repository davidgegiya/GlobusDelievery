@extends('layouts.app')

@section('docname', $rest_name)

@section('content')

    <div class="margin" style="margin-top: 3em;"></div>
    @for ($i = 0; $i < count($categories); $i++)
        <div class="container" style="background-color: palegoldenrod; margin-bottom: 2em">
            <h1 style="padding: 2em">{{ $categories[$i]->name }}</h1>
            <div class="row">
                @foreach($meals[$i] as $meal)
                    <div class="col-sm-6 mx-auto">
                        <div class="card text-center mx-auto"
                             style="padding:20px; max-width:400px; height: 30em; margin-bottom: 3em">
                            <img src="{{ $meal->image }}" class="card-img-top mx-auto" style="width:300px;"
                                 alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $meal->name }}</h5>
                            </div>
                            <div class="card-footer">
                                <div class="row" style="display: flex; flex-direction: row">
                                    <div
                                        class="delivery-price-group col mx-auto d-flex align-items-center justify-content-center">
                                        {{ $meal->price }} ₽
                                    </div>
                                    <div class="add-to-cart-group col d-flex align-items-center justify-content-center">
                                        <div class="cart">
                                            @php
                                                $cond = false;
                                                $curr_item = null;
                                                if($order_items){
                                                    foreach($order_items as $order_item){
                                                        if($order_item->meal_id == $meal->id){
                                                            $cond = true;
                                                            $curr_item = $order_item;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @if(!$cond)
                                                <button class="btn btn-primary"
                                                        onclick="addToCart('{{ $meal->id }}', this, '{{ $meal->price }}')">
                                                    <i class="bi bi-basket"></i>
                                                </button>
                                            @else
                                                <div
                                                    class="set-count-group row d-flex align-items-center justify-content-center"
                                                    style="padding: 0.5em;" id="{{ $meal->id }}">
                                                    <button class="btn btn-secondary col"
                                                            onclick="decrease('{{ $meal->id }}')">
                                                        <i class="bi bi-dash-square"></i>
                                                    </button>
                                                    <div class="container col">
                                                        <span>{{ $curr_item->count }}</span>
                                                    </div>
                                                    <button class="btn btn-secondary col"
                                                            onclick="increase('{{ $meal->id }}')">
                                                        <i class="bi bi-plus-square"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endfor

    <div id="conditional">
        @if($current_order)
            @if($current_order->total_price)
                <a href="{{ route('user.cart') }}">
                    <div class="container fixed-bottom text-center"
                         style="background-color: yellow; max-width: 10em; left: 80%; bottom: 10%; font-size: 2em; padding: 1em; border-radius: 80%">
                        {{ $current_order->total_price }}
                        <i class="bi bi-cart"></i>
                    </div>
                </a>
            @endif
        @endif
    </div>

    <script>
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

        let makeRequest = (id, caller) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '{{ route('user.addToCart') }}',
                data: {
                    'id': id,
                },
                datatype: 'json',
                success: function (data) {
                    if (!data.errors) {
                        getOrder(data.id).then((price) => {
                            $(caller).replaceWith(
                                "                                            <div id=" + id + " class=\"set-count-group row d-flex align-items-center justify-content-center\" style=\"padding: 0.5em;\">\n                                                <button class=\"btn btn-secondary col\" onclick=\"decrease(\'" + id + "\')\">\n                                                    <i class=\"bi bi-dash-square\"></i>\n                                                </button>\n                                                <div class=\"container col\">\n                                                    <span>1</span>\n                                                </div>\n                                                <button class=\"btn btn-secondary col\" onclick=\"increase(\'" + id + "\')\">\n                                                    <i class=\"bi bi-plus-square\"></i>\n                                                </button>\n                                            </div>"
                            );
                            $('#conditional').replaceWith(" <div id='conditional'>               <a href='{{ route('user.cart') }}'> <div class=\"container fixed-bottom text-center\"\n             style=\"background-color: yellow; max-width: 10em; left: 80%; bottom: 10%; font-size: 2em; padding: 1em; border-radius: 80%\">\n            " + price + "\n            <i class=\"bi bi-cart\"></i>\n        </div>\n </a> </div>");
                        });
                    }
                },
                error: function (error) {
                    if(error.status == 401){
                        window.location.href = '{{ route('user.login') }}';
                    }
                }
            });
        }

        let addToCart = (id, caller) => {
            makeRequest(id, caller);
        }

        let increase = (id) => {
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
                        console.log(data);
                        getOrder(data.id).then((price) => {
                            console.log(price);
                            $('#conditional').replaceWith(" <div id='conditional'>   <a href='{{ route('user.cart') }}'>    <div class=\"container fixed-bottom text-center\"\n             style=\"background-color: yellow; max-width: 10em; left: 80%; bottom: 10%; font-size: 2em; padding: 1em; border-radius: 80%\">\n            " + price + "\n            <i class=\"bi bi-cart\"></i>\n        </div>\n </a> </div>");
                            $('#' + id).children("div").replaceWith("                                                    <div class=\"container col\" id=" + id + ">\n                                                        <span>" + count + "</span>\n                                                    </div>");
                        });
                    }
                },
            });
        }

        let decrease = (id) => {
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
                            $('#' + id).replaceWith("                                            <button class=\"btn btn-primary\" onclick=\"addToCart(\'" + id + "\', this)\">\n                                                <i class=\"bi bi-basket\"></i>\n                                            </button>");
                        } else {
                            count -= 1;
                            $('#' + id).children("div").replaceWith("                                                    <div class=\"container col\" id=" + id + ">\n                                                        <span>" + count + "</span>\n                                                    </div>");
                        }
                        getOrder(data.id).then((price) => {
                            if (!price) {
                                $('#conditional').replaceWith("<div id='conditional'></div>");
                            } else
                                $('#conditional').replaceWith(" <div id='conditional'>    <a href='{{ route('user.cart') }}'>    <div class=\"container fixed-bottom text-center\"\n             style=\"background-color: yellow; max-width: 10em; left: 80%; bottom: 10%; font-size: 2em; padding: 1em; border-radius: 80%\">\n            " + price + "\n            <i class=\"bi bi-cart\"></i>\n        </div>\n </a> </div>");
                        });
                    }
                },
            });
        }

    </script>
@endsection
