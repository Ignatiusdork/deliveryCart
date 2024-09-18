<h1>Ticket #{{ $ticket->id }} - {{ $ticket->subject }}</h1>
<p>Status: {{ $ticket->status }}</p>
<p>{{ $ticket->message }}</p>

<h2>Replies:</h2>
<ul>
    @foreach($ticket->replies as $reply)
        <li>{{ $reply->message }}</li>
    @endforeach
</ul>

<form method="POST" action="{{ route('tickets.reply', $ticket->id) }}">
    @csrf
    <textarea name="message"></textarea>
    <button type="submit">Reply</button>
</form>
