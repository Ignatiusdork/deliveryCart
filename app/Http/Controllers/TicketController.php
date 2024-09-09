<?php

namespace App\Http\Controllers;
use App\Services\TicketService;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    private $ticketService;

    public function __construct(TicketService $ticketService) {
        $this->ticketService = $ticketService;
    }

    public function create() {
        return view('tickets.create');
    }

    public function store(Request $request) {
        
    }
}
