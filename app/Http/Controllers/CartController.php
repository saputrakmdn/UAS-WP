<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;

class CartController extends Controller
{
    protected $cacheKey = 'cart-user-';

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'return_date' => 'required',
            'qty'    => "required|array|min:1",
            'qty.*'  => "required|numeric|min:1",
        ]);

        $cacheKey = $this->cacheKey.auth()->user()->id;
        $dataBook = Cache::get($cacheKey);
        $randomString=rand();
        $transcationCode = md5($randomString);
        $detailTransaction = array();

        foreach ($dataBook as $key => $book)
        {
            $checkStock = Book::find($book['id'])->checkStock($request->qty[$book['id']]);

            if(!$checkStock)
                return back()->withErrors(['message' => 'Failed! Book '.$book['book_name'].' not available, please remove from cart.']);

            $detailTransaction[$key] = new DetailTransaction(['detail_transaction_qty' => $request->qty[$book['id']], 'detail_transaction_return_date' => $request->return_date, 'detail_transaction_book_id' => $book['id']]);
            //calculate stock book
            $detailTransaction[$key]->book()->decrement('book_stock', $request->qty[$book['id']]);

        }

        $transaction = Transaction::create([
            'transaction_code' => $transcationCode,
            'transaction_date' => now(),
            'transaction_status' => 1,
            'transaction_user_id' => $request->user()->id
        ]);

        $transaction->detailTransaction()->saveMany($detailTransaction);

        Cache::forget($cacheKey);
        return back();
    }

    public function addToCart(Request $request)
    {
        $cacheKey = $this->cacheKey.$request->user()->id;
        $data = Book::with('bookType:id,book_type_name')->find($request->id)->toArray();
        $value[] = $data;

        if(Cache::has($cacheKey)){
            $dataCart = Cache::get($cacheKey);
            $checkItem = collect($dataCart)->firstWhere('id', $request->id);
            if(!is_null($checkItem))
                return back()->withErrors(['message' => 'Item Already on Cart!']);
            $dataCart[] = $data;
            $value = $dataCart;
        }

        Cache::put($cacheKey, $value);

        return back();
    }

    public function cart()
    {
        $cacheKey = $this->cacheKey.auth()->user()->id;
        $data = Cache::get($cacheKey) ?? [];

        return Inertia::render('Cart/Index', [
            'data' => $data
        ]);
    }

    public function deleteCart(Request $request)
    {
        $cacheKey = $this->cacheKey.$request->user()->id;
        $data = Cache::get($cacheKey);
        $data = collect($data)->where('id', '!=',$request->id)->values()->toArray();

        Cache::put($cacheKey, $data);

        return back();

    }
}
