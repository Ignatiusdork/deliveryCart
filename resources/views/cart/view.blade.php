@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex flex-col items-center">
    <h1 class="text-3xl font-bold mb-6 pt-6">Your Cart</h1>
    @if(count($items) > 0)
        <table class="min-w-full bg-white border border-gray-200 w-3/4">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Product</th>
                    <th class="py-3 px-6 text-center">Quantity</th>
                    <th class="py-3 px-6 text-center">Price</th>
                    <th class="py-3 px-6 text-center">Total</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>

            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($items as $item)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $item['item']->name}}</td>
                    <td class="py-3 px-6 text-center">{{ $item['quantity'] }}</td>
                    <td class="py-3 px-6 text-center">${{ $item['item']->price }}</td>
                    <td class="py-3 px-6 text-center">${{ $item['item']->price * $item['quantity'] }}</td>
                    <td class="py-3 px-6 text-center">
                        <form action="{{ route('cart.remove', $item['item']->id)}}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 ml-4 mb-3">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="cart-total mt-6 w-3/4 text-right">
            <h3 class="text-xl font-semibold">Total Price: ${{ $total }}</h3>
        </div>
        <div class="mt-6 w-3/4 text-right">
            <form action="{{ route('order.place') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 text-black px-4 py-2">Place Order</button>
            </form>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
