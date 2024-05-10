<?php

namespace App\Http\Traits;

use App\Events\BookBorrowed;
use App\Events\BookReturned;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait BookManagementTrait
{
    public function attachBooksToUser(Request $request)
    {
        try {
            DB::beginTransaction();

            $user_id = Auth::user()->id;
            $user = User::findOrFail($user_id);

            $unavailableBooks = [];
            $borrowedBooks = [];
            foreach ($request->book_ids as $book_id) {
                $book = Book::findOrFail($book_id);
                if (!$book->available) {
                    $unavailableBooks[] = $book;
                    continue;
                }
                $borrowedBooks[] = $book;
                $book->decreaseCopies();
                $user->books()->attach($book->id);
            }

            DB::commit();

            event(new BookBorrowed($borrowedBooks));

            $borrowed_books= BookResource::collection($borrowedBooks);
            $data['borrowed_books'] = $borrowed_books;

            if (!$unavailableBooks) {
                $unavailable_books  = BookResource::collection($unavailableBooks);
                $data['unavailable_books'] =$unavailable_books;
            }

            return $data;
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
        }
    }

    public function detachBooksFromUser(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);

        $book_ids = $request->input('book_ids');

        $returnBooks = [];
        foreach ($book_ids as $book_id) {
            $book = Book::findOrFail($book_id);
            $returnBooks[] = $book;
            $book->increaseCopies();
            $user->books()->detach($book);
        }
        event(new BookReturned($returnBooks));

        return BookResource::collection($returnBooks);
    }
}
