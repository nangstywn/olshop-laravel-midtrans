@extends('layouts/main')

@section('content')

<div class="container" style="margin-top: 40px;">

    <div class="row">
        <div class="col-sm-12 locations text-center">
            <h2>ORDERS</h2><br><br>
            @if (count($orders) == 0)
            <p>You do not have an order yet</p>
            @else
            <table class="table table-bordererd table-striped">
                <tr>
                    <th>Orders ID</th>
                    <th>Order Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach($orders as $order)
                <tr class="text-$order">
                    <td>PN-{{ $order->id }}</td>
                    <td>{{ Rupiah::getRupiah($order->order_price) }}</td>
                    @if($order->status == 'capture' || $order->status == 'settlement')
                    <td class="badge badge-success badge-pill" style="font-size: 12px; ">Lunas</td>
                    @else
                    <td class="badge badge-warning badge-pill" style="font-size: 12px;">Blm bayar</td>
                    @endif
                    <td><a href=" /orders/{{$order->id}}" class="btn-sm btn-success">Detail</a></td>
                </tr>
                @endforeach
            </table>
            @endif
        </div>
    </div>
</div><!-- Container /- -->
@endsection