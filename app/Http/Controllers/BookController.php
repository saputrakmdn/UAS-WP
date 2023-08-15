<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::with('bookType:id,book_type_name')->get()->map(function ($item, $index) {
            $newArray = ['number' =>  $index + 1, 'book_type' => $item->bookType->book_type_name];
            return $newArray + $item->toArray();
        });

        $bookType = BookType::get();

        return Inertia::render('Book/Index', [
            'records' => $data,
            'bookType' => $bookType
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'publisher' => 'required',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'stock' => 'required|integer|min:1',
            'book_type' => 'required'
        ]);

        Book::create([
            'book_name' => $request->name,
            'book_description' => $request->description,
            'book_publisher' => $request->publisher,
            'book_year' => $request->year,
            'book_stock' => $request->stock,
            'book_type_id' => $request->book_type
        ]);

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'publisher' => 'required',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+1),
            'stock' => 'required|integer|min:1',
            'book_type' => 'required'
        ]);

        $book->update([
            'book_name' => $request->name,
            'book_description' => $request->description,
            'book_publisher' => $request->publisher,
            'book_year' => $request->year,
            'book_stock' => $request->stock,
            'book_type_id' => $request->book_type
        ]);

        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return back();
    }

    public function list()
    {
        $data = Book::with('bookType:id,book_type_name')->get();
        return Inertia::render('Book/List', [
            'books' => $data
        ]);
    }
}
