@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6 mt-9">Products</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($products as $product)
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
                <a href="{{ route('products.show', $product->id) }}" class="block">
                    <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                </a>
                <p class="mb-2 text-gray-700">{{ $product->description }}</p>
                <p class="text-lg font-bold">Price: ${{ $product->price }}</p>
            </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection

