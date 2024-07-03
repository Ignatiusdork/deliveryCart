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
                    <th>Actions</th>
                </tr>

            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['item']->name}}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ $item['item']->price }}</td>
                    <td>${{ $item['item']->price * $item['quantity'] }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item['item']->id)}}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 ml-4">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="cart-total">
            <h3>Toal Price: ${{ $total }}</h3>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
