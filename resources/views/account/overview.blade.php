<h1>Account Overview</h1>

<p>Name: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>

<h2>Recent Orders:</h2>
<ul>
    @foreach($orders as $order)
        <li>{{ $order->id ?? 'N/A' }} - {{ $order->status }}</li>
    @endforeach
</ul>
