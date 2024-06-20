@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    @if(count($items) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['item']['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ $item['item']['price'] }}</td>
                    <td>${{ $item['item']['price'] * $item['quantity'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
