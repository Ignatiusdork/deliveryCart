<h1>Your Tickets</h1>
<ul>
    @foreach($tickets as $ticket)
        <li><a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->subject }}</a> - {{ $ticket->status }}</li>
    @endforeach
</ul>
