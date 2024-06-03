<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
    $tickets = Ticket::where('event_id', $event->id)->paginate(10);

    return view('admin.events.tickets.index', compact('event', 'tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
    return view('admin.events.tickets.form', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, TicketRequest $request)
    {
    // Add event id
    $request->merge(['event_id' => $event->id]);

    // Create ticket
    Ticket::create($request->all());

    // Return to index
    return redirect()->route('admin.events.tickets.index', $event->id)->with('success', 'Ticket created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, Ticket $ticket)
    {
    return view('admin.events.tickets.form', compact('event', 'ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Event $event, TicketRequest $request, string $id)
    {
    // Update ticket
    Ticket::find($id)->update($request->all());

    // Return to index
    return redirect()->route('admin.events.tickets.index', $event->id)->with('success', 'Ticket updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Ticket $ticket)
    {
    // Delete ticket
    $ticket->delete();

    // Return to index
    return redirect()->route('admin.events.tickets.index', $event->id)->with('success', 'Ticket deleted');
    }
}
