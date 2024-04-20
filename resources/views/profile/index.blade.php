@extends('layouts.app')



    @section('content')
        <h1>Products</h1>
        @foreach ($products as $product)
            <div>
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p>Price: ${{ $product->price }}</p>
            </div>
        @endforeach
    @endsection

