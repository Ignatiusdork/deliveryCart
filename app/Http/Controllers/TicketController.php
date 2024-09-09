<?php

namespace App\Http\Controllers;
use App\Services\TicketService;
use Exception;
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

        $ticket = $this->ticketService->createTicket($request->all());

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully');
    }

    public function index() {
        $tickets = $this->ticketService->getTickets();

        return view('tickets.index', compact('tickets'));
    }

    public function show($ticketId) {

        $ticket = $this->ticketService->getTicketDetails($ticketId);

        return view('tickets.show', compact('ticket'));
    }

    public function reply(Request $request, $ticketId) {

        $reply = $this->ticketService->replyToTicket($ticketId, $request->all());

        return redirect()->back()>with('success', 'Reply added successfully');
    }

    public function updateStatus(Request $request, $ticketId) {

        $newStatus = $request->input('status');

        try {

            $updatedTicket = $this->ticketService->updateStatus($ticketId, $newStatus);
            return redirect()->back()->with('success', 'Ticket status updated successfully');

        } catch (Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function close(Request $request, $ticketId) {
        try {

            $updateTicket = $this->ticketService->closeTicket($ticketId);
            return redirect()->back()->with('success', 'Ticket closed successfully');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getStatuses() {

        $statuses =  $this->ticketService->getTicketStatuses();
        return view('tickets.statuses', compact('statuses'));
    }
}
