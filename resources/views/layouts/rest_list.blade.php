<div class="row" id="inc-temp" style="margin-top: 1em;">
    @foreach($restaurants as $restaurant)
        <div class="col-sm-6 mx-auto">
            <a href="{{ route('user.restContent', $restaurant->name) }}" class="card text-center mx-auto" style="padding:20px; max-width:400px; margin-bottom: 3em">
                <img src="{{ $restaurant->image }}" class="card-img-top mx-auto" style="width:300px;" alt="">
                <div class="card-body">
                    <h5 class="card-title">{{ $restaurant->name }}</h5>
                </div>
                <div class="card-footer">
                    <div class="row" style="display: flex; flex-direction: row">
                        <div class="rating-group col-3">
                            <i class="bi bi-star-fill" style="color: yellow"></i>
                            {{ $restaurant->rating }}
                        </div>
                        <div class="delivery-price-group col-4">
                            <i class="bi bi-currency-dollar" style="color: green"></i>
                            От {{ $restaurant->delivery_price }} ₽
                        </div>
                        <div class="delivery-time-group col-5">
                            <i class="bi bi-truck"></i>
                            {{ $restaurant->delivery_time }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
    @if(count($restaurants) == 0)
        <div class="card text-center mx-auto" style="padding:20px; max-width:400px; margin-bottom: 3em">
            <h1>Извините, ничего не найдено :(</h1>
        </div>
    @endif
</div>

