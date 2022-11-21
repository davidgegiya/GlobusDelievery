@extends('layouts.app')

@section('docname', 'Restaurants')

@section('content')
    @include('layouts.rest_list')
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
@endsection

@section('search_sort')
    <form method="post" style="max-width: 700px; margin-top: 3em" class="form-group text-center mx-auto">
        @csrf
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">Поиск...</span>
            <input type="text" class="form-control" name="search" id="search">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="bi bi-filter"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <button class="dropdown-item" type="button" onclick="actionSort('name')">Имени</button>
                </li>
                <li>
                    <button class="dropdown-item" type="button" onclick="actionSort('rating')">Рейтингу</button>
                </li>
                <li>
                    <button class="dropdown-item" type="button" onclick="actionSort('delivery_price')">Стоимости
                        доставки
                    </button>
                </li>
                <li>
                    <button class="dropdown-item" type="button" onclick="actionSort('delivery_time')">Времени доставки
                    </button>
                </li>
            </ul>
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i id="ic-sort-type" class="bi bi-sort-up"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <button class="dropdown-item" type="button" onclick="actionSortType('ASC')">По возрастанию</button>
                </li>
                <li>
                    <button class="dropdown-item" type="button" onclick="actionSortType('DESC')">По убыванию</button>
                </li>
            </ul>
        </div>
        <input type="hidden" id="sort" value="name" name="sort">
        <input type="hidden" id="sort-type" value="ASC" name="sort-type">
    </form>

    <script>
        let actionSort = (n) => {
            $("#sort").val(n);
            makeRequest();
        }
        let actionSortType = (n) => {
            $("#sort-type").val(n);
            switch (n) {
                case 'ASC':
                    $("#ic-sort-type").replaceWith("<i id=\"ic-sort-type\" class=\"bi bi-sort-up\"></i>");
                    break;
                case 'DESC':
                    $("#ic-sort-type").replaceWith("<i id=\"ic-sort-type\" class=\"bi bi-sort-down\"></i>");
                    break;
            }
            makeRequest();
        }

        let makeRequest = () => {
            $.ajax({
                type: 'post',
                url: '{{ route('user.search') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'data': $('input[name=search]').val(),
                    'sort': $('input[name=sort]').val(),
                    'sort-type': $('input[name=sort-type]').val()
                },
                datatype: 'json',
                success: function (data) {
                    console.log(data);
                    $('#inc-temp').replaceWith(data);
                },
            });
        }

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $("#search").keyup(function (e) {
            e.preventDefault();
            makeRequest();
        });
    </script>
@endsection
