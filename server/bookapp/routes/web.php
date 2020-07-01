<?php

use Illuminate\Support\Facades\Route;
use App\Book;
use Illuminate\support\facades\Validator;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $books = Book::all();
    return view('books', ['books'=>$books]);
});

Route::post('/book', function (Request $request) {
    $validateor = Validator::make($request->all(), [
        'name' => 'required|max:255'
    ]);

    if ($validateor->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validateor);
    }

    $book = new Book;
    $book->title = $request->name;
    $book->save();

    return redirect('/');
});

Route::delete('/book/{book}', function(Book $book) {
    $book->delete();
    return redirect('/');
});