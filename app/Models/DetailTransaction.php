<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $table = 'detail_transaction';
    protected $primaryKey = 'id';
    protected $fillable = ['detail_transaction_qty', 'detail_transaction_return_date', 'detail_transaction_actual_return_date', 'detail_transaction_fine_days', 'detail_transaction_fine', 'detail_transaction_book_id', 'detail_transaction_transaction_id'];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'detail_transaction_transaction_id','id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'detail_transaction_book_id', 'id');
        ;
    }
}
