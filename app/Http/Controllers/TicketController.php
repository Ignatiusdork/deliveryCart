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
}
