<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Mail\TicketMail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
    $transactions = Transaction::with('transactionDetails.ticket')->where('event_id', $event->id)->paginate(10);

    return view('admin.events.transactions.index', compact('event', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Transaction $transaction)
    {
    // Delete transaction
    $transaction->delete();

    // Return to index
    return redirect()->route('admin.events.transactions.index', $event->id)->with('success', 'Transaction deleted');
    }

    public function pdf(Event $event, Transaction $transaction)
    {
    $pdf = Pdf::loadView('pdf.ticket', compact('event', 'transaction'));

    return $pdf->stream();
    }

    /**
 * Approve the specified resource from storage.
 */
    public function approve(Request $request, $eventId, $transactionId)
    {

    $transaction = Transaction::findOrFail($transactionId);

    if ($transaction->status === 'pending') {

    $transaction->status = 'success';

    $transaction->save();

    return response()->json(['success' => true, 'message' => 'Transaction approved successfully.']);

    }

    return response()->json(['success' => false, 'message' => 'Transaction is not in pending state.']);

    }

}