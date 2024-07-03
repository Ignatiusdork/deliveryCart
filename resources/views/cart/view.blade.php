@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>
    @if(count($items) > 0)
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Product</th>
                    <th class="py-3 px-6 text-center">Quantity</th>
                    <th class="py-3 px-6 text-center">Price</th>
                    <th class="py-3 px-6 text-center">Total</th>
                    <th class="py-3 px-6 text-center">Actions</th>
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
