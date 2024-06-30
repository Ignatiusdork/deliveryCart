<!-- resources/views/products/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-4">
    <p class="mb-2"><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <!-- Add more product details as needed -->

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-green-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex items-center mt-4">
        <button id="decrement" class="bg-gray-200 text-gray-700 px-4 py-2">-</button>
        <input type="text" id="quantity" value="1" class="mx-2 text-center w-12" readonly>
        <button id="increment" class="bg-gray-200 text-gray-700 px-4 py-2">+</button>
    </div>

    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="quantity" id="formQuantity" value="1">
        <button type="submit" class="bg-blue-500 text-black px-4 py-2">Add to Cart</button>
    </form>

    <!-- Display cart info and go to cart button -->
    <div class="mt-4">
        <p><strong>Items in Cart:</strong> {{ session('cart') ? count(session('cart'))  : 0 }}</p>
        <a href="{{ route('cart.view') }}" class=""></a>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const decrementButton = document.getElementById('decrement');
        const incrementButton = document.getElementById('increment');
        const quantityInput = document.getElementById('quantity');
        const formQuantityInput = document.getElementById('formQuantity');

        decrementButton.addEventListener('click', function () {
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantity--;
                quantityInput.value = quantity;
                formQuantityInput.value = quantity;
            }
        });

        incrementButton.addEventListener('click', function () {
            let quantity = parseInt(quantityInput.value);
            quantity++;
            quantityInput.value = quantity;
            formQuantityInput.value = quantity;
        });
    });
</script>
@endsection

