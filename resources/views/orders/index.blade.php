@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Your Orders</h1>
    @if($orders->count() > 0)
        <table class="min-w-full bg-white border border-gray-200 mt-6">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Order ID</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Total Price</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($orders as $order)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">#{{ $order->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $order->status }}</td>
                    <td class="py-3 px-6 text-left">${{ $order->total_price }}</td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('orders.show', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">You have no orders.</p>
    @endif
</div>
@endsection
