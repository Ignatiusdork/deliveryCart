@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Order #{{ $order->id }}</h1>
    <p>Status: {{ $order->status }}</p>
    <p>Total Price: ${{ $order->total }}</p>
    <table class="min-w-full bg-white border border-gray-200 mt-6">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Product</th>
                <th class="py-3 px-6 text-center">Quantity</th>
                <th class="py-3 px-6 text-center">Price</th>
                <th class="py-3 px-6 text-center">Total</th>
                <th class="py-3 px-6 text-center">Status</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($order->orderItems as $item)
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $item->product->name }}</td>
                <td class="py-3 px-6 text-center">{{ $item->quantity }}</td>
                <td class="py-3 px-6 text-center">${{ $item->price }}</td>
                <td class="py-3 px-6 text-center">${{ $item->price * $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
