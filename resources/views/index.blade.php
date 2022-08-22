@extends('layouts/main')

@section('content')

<!-- Slider -->
<style>
.addqty {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    text-align: center;
}

.qty {
    width: 40px;
    height: 25px;
    text-align: center;
    border: 1px solid gainsboro;
}

input.qtyplus {
    width: 30px;
    height: 25px;
    cursor: pointer;
    border: 1px solid gainsboro;
}

input.qtyminus {
    width: 30px;
    height: 25px;
    cursor: pointer;
    border: 1px solid gainsboro;
}
</style>
<div class="main_slider" style="background-image:url('assets/images/slider_1.jpg')">
    <div class="container fill_height">
        <div class="row align-items-center fill_height">
            <div class="col">
                <div class="main_slider_content">
                    <h6>Spring / Summer Collection 2017</h6>
                    <h1>Get up to 30% Off New Arrivals</h1>
                    <div class="red_button shop_now_button"><a href="#">shop now</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Arrivals -->

<div class="new_arrivals">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title new_arrivals_title">
                    <h2>New Arrivals</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col text-center">
                <div class="new_arrivals_sorting">
                    <ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center active is-checked"
                            data-filter="*">all
                        </li>
                        @foreach($categoryMenu as $menu)
                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center"
                            data-filter=".{{ $menu->id }}">{{ $menu->category_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>
                    @foreach($products as $key => $product)
                    <a href="/product/{{$product->slug}}">
                        <div class="product-item {{$product->category_id}} ">
                            <div class="product discount product_filter">
                                <div class="product_image">
                                    {!! $img[$key]['thumbs'] !!}
                                </div>

                                <div class="product_info">
                                    <h6 class="product_name"><a
                                            href="/product/{{$product->slug}}">{{ $product->product_name }}</a>
                                    </h6>

                                    <div class="product_price">
                                        {{ Rupiah::getRupiah(($product->product_price)) }}
                                        <span>{{ Rupiah::getRupiah(($product->original_price )) }}
                                        </span>
                                    </div>
                                    <p class="addqty">
                                        <input type='button' value='-' class='qtyminus minus' field='quantity' />
                                        <input type='text' name='quantity' id="quantity" value='1' class='qty' />
                                        <input type='button' value='+' class='qtyplus plus' field='quantity' />
                                    </p>
                                    <div>
                                        <span>{{$product->qty}} Terjual</span>
                                    </div>
                                    {{-- <input type="number" class="quantity" id="quantity" name="quantity" value="1" style="width: 50px; margin-right: 10px;"> --}}
                                </div>
                            </div>
                            <div class="add_to_cart_button red_button"><a
                                    href="{{ route('basket.create', ['id' => $product->id]) }}">add to cart</a>
                            </div>
                        </div>
                    </a>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deal of the week -->

<div class="deal_ofthe_week">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="deal_ofthe_week_img">
                    <img src="{{ asset('assets/images/deal_ofthe_week.png')}}" alt="">
                </div>
            </div>
            <div class="col-lg-6 text-right deal_ofthe_week_col">
                <div class="deal_ofthe_week_content d-flex flex-column align-items-center float-right">
                    <div class="section_title">
                        <h2>Deal Of The Week</h2>
                    </div>
                    <ul class="timer">
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="day" class="timer_num">03</div>
                            <div class="timer_unit">Day</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="hour" class="timer_num">15</div>
                            <div class="timer_unit">Hours</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="minute" class="timer_num">45</div>
                            <div class="timer_unit">Mins</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="second" class="timer_num">23</div>
                            <div class="timer_unit">Sec</div>
                        </li>
                    </ul>
                    <div class="red_button deal_ofthe_week_button"><a href="#">shop now</a></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Benefit -->

<div class="benefit">
    <div class="container">
        <div class="row benefit_row">
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>free shipping</h6>
                        <p>Suffered Alteration in Some Form</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-money" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>cash on delivery</h6>
                        <p>The Internet Tend To Repeat</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>45 days return</h6>
                        <p>Making it Look Like Readable</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 benefit_col">
                <div class="benefit_item d-flex flex-row align-items-center">
                    <div class="benefit_icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                    <div class="benefit_content">
                        <h6>opening all week</h6>
                        <p>8AM - 09PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('js')


<script>
$(document).ready(($) => {
    $('.add_to_cart_button').find('a').click(function(event) {
        event.preventDefault();
        var quantity = $(this).parent().prev().find('input[name="quantity"]').val();
        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            data: {
                quantity: quantity
            },
            success: function(data) {
                console.log(data);
                $('#checkout_items').html(data.cartCount);
            }
        });
        return false; //for good measure
    });


    $('.addqty').on('click', '.plus', function(e) {
        let $input = $(this).prev('input.qty');
        let val = parseInt($input.val());
        $input.val(val + 1).change();
    });

    $('.addqty').on('click', '.minus',
        function(e) {
            let $input = $(this).next('input.qty');
            var val = parseInt($input.val());
            if (val > 0) {
                $input.val(val - 1).change();
            }
        });
});
</script>

@endsection