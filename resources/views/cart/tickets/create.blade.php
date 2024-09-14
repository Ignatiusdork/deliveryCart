<form method="POST" action="{{ route('tickets.store') }}">
    @csrf
    <input type="text" name="subject" placeholder="Subject">
    <textarea name="message" placeholder="Message"></textarea>
    <button type="submit">Create Ticket</button>
</form>
