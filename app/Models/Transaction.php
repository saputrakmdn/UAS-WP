<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $primaryKey = 'id';

    protected $fillable = ['transaction_code', 'transaction_date', 'transaction_status', 'transaction_fine_total', 'transaction_user_id'];
    protected $hidden = ['created_at', 'updated_at'];


    public function detail(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'detail_transaction', 'detail_transaction_transaction_id', 'detail_transaction_book_id')->withPivot('detail_transaction_qty', 'detail_transaction_return_date', 'detail_transaction_actual_return_date', 'detail_transaction_fine_days', 'detail_transaction_fine');
    }

    public function detailTransaction():HasMany
    {
        return $this->hasMany(DetailTransaction::class, 'detail_transaction_transaction_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'transaction_user_id', 'id');
    }

}
