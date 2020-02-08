<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store() {
        $data = request()->validate([
            'title'=> 'required',
            'author'=> 'required'
        ]);
        Book::create([
           'title'=> request('title'),
           'author'=> request('author'),
        ]);
    }
}
