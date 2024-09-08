<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Validator;

class TicketService {
    public function createTicket(array $data) {
        Validator::make($data, [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ])->validate();

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => 'open'
        ]);

        return $ticket;
    }

    public function getTickets() {
        return Ticket::where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function getTicketDetails(int $ticketId) {
        return Ticket::where('user_id', auth()->id())
            ->findOrFail($ticketId);
    }
}
