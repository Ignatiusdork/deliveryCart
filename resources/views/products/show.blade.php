<!-- resources/views/products/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-4">
    <p class="mb-2"><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <!-- Add more product details as needed -->
</div>
@endsection
