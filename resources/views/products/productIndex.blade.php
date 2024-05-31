<!-- resources/views/profile/index.blade.php or wherever your products listing is -->

@foreach ($products as $product)
    <div>
        <a href="{{ route('products.show', $product->id) }}" class="text-blue-500 hover:text-blue-700">
            <h2>{{ $product->name }}</h2>
        </a>
        <p>{{ $product->description }}</p>
        <p>Price: ${{ $product->price }}</p>
    </div>
@endforeach
