<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    use HasFactory;
    protected $table = 'book_type';
    protected $primaryKey = 'id';
    protected $fillable = ['book_type_name'];
}
