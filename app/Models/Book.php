<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use function Termwind\render;

class Book extends Model
{
    use HasFactory;
    protected $table = 'book';
    protected $primaryKey = 'id';
    protected $fillable = ['book_name', 'book_description', 'book_publisher', 'book_year', 'book_stock', 'book_type_id'];

    public function bookType(): HasOne
    {
        return $this->hasOne(BookType::class, 'id', 'book_type_id');
    }

    public function checkStock($qty)
    {
        return $this->book_stock >= $qty;
    }
}
