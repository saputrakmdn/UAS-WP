<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailTransactionResource;
use App\Http\Resources\ReportingResource;
use App\Models\DetailTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportingController extends Controller
{
    public function index(Request $request)
    {

        $reporting = DetailTransaction::query()->join('book','detail_transaction_book_id', '=', 'book.id')->join('transaction', 'detail_transaction_transaction_id', '=', 'transaction.id')->join('users', 'transaction.transaction_user_id', '=', 'users.id');
        if(!is_null($request->transaction_date))
            $reporting = $reporting->where('transaction.transaction_date', '=', $request->transaction_date);

        if(!is_null($request->return_date))
            $reporting = $reporting->where('detail_transaction.detail_transaction_return_date', '=', $request->return_date);
        $reporting = $reporting->get();

        $data = [];

        foreach ($reporting as $value)
        {
            $status = $value->detail_transaction_return_date < $value->detail_transaction_actual_return_date ? 'Late' : 'On Time';
            $data[] = [
                'book_name' => $value->book_name,
                'user' => $value->name,
                'transaction_date' => $value->transaction_date,
                'qty' => $value->detail_transaction_qty,
                'return_date' => $value->detail_transaction_return_date,
                'actual_return_date' => $value->detail_transaction_actual_return_date,
                'status' => $status,
                'fine_days' => $value->detail_transaction_fine_days,
                'fine' => $value->detail_transaction_fine
            ];
        }

        $late = collect($data)->where('status', '=', 'Late')->count();
        $onTime = collect($data)->where('status', '=', 'On Time')->count();

        $dataStatus = [$late, $onTime];

        return Inertia::render('Reporting/Index', [
            'data' => $data,
            'dataStatus' => $dataStatus
        ]);
    }
}
