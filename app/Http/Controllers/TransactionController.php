<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailTransactionResource;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DateTime;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transaction::with('user:id,name')->get();
        return Inertia::render('Transaction/Index', [
            'records' => $data
        ]);
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
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function detail($id)
    {
        $data = DetailTransaction::with('book:id,book_name')->where('detail_transaction_transaction_id', '=', $id)->get();
        $data = DetailTransactionResource::collection($data);
        return response($data, 200);
    }

    public function listTransaction()
    {
        $transaction = Transaction::where('transaction_user_id', '=', auth()->user()->id)->get();

        return Inertia::render('ReturnBook/Index', [
            'records' => $transaction
        ]);
    }

    public function returnBook(DetailTransaction $detailTransaction)
    {
        $date = date('Y-m-d');
        $date1 = new DateTime($detailTransaction->detail_transaction_return_date);
        $date2 = new DateTime($date);
        $interval = $date1->diff($date2);
        $fineDays = $interval->days;
        $fine = $fineDays <= 10 ? (10000 * $fineDays * $detailTransaction->detail_transaction_qty) : 120000;
        $status = 1;
        $checkReturnAllBook = DetailTransaction::where('detail_transaction_transaction_id', '=', $detailTransaction->detail_transaction_transaction_id)->where('detail_transaction_actual_return_date', '=', null)->count();
        if($checkReturnAllBook > 1){
            $status = 2;
        }else{
            $status = 3;
        }

        $detailTransaction->update([
            'detail_transaction_actual_return_date' => $date,
            'detail_transaction_fine_days'  => $fineDays > 0 ? $fineDays :0,
            'detail_transaction_fine' => $fine

        ]);

        $totalFine = DetailTransaction::where('detail_transaction_transaction_id', '=', $detailTransaction->detail_transaction_transaction_id)->where('detail_transaction_actual_return_date', '!=', null)->sum('detail_transaction_fine');

        $detailTransaction->transaction()->update([
            'transaction_status' => $status,
            'transaction_fine_total' => $totalFine
        ]);

        $detailTransaction->book()->increment('book_stock', $detailTransaction->detail_transaction_qty);

        return back();
    }
}
