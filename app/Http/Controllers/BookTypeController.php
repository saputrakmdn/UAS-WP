<?php

namespace App\Http\Controllers;

use App\Models\BookType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BookType::get()->map(function ($item, $index) {
            $number = ['number' =>  $index + 1];
            return $number + $item->toArray();
        });

        return Inertia::render('BookType/Index', ['records'=> $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        BookType::create(['book_type_name' => $request->name]);
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookType $bookType)
    {
        $request->validate(['name' => 'required']);

        $bookType->update(['book_type_name' => $request->name]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookType $bookType)
    {
        $bookType->delete();

        return back();
    }
}
