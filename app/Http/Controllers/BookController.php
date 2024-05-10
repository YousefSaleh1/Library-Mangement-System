<?php

namespace App\Http\Controllers;

use App\Events\BookAdded;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;;
use App\Http\Resources\BookResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Cache::remember('books', 60, function () {
            return Book::all();
        });
        $data  = BookResource::collection($books);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'rate'          => $request->rate,
            'publish_date'  => $request->publish_date,
            'copies_number' => $request->copies_number,
        ]);
        $book->authors()->attach($request->author_ids);
        event(new BookAdded($book));
        $data = new BookResource($book);
        return $this->customeResponse($data, 'Created Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $data = new BookResource($book);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->title         = $request->input('title') ?? $book->title;
        $book->description   = $request->input('description') ?? $book->description;
        $book->rate          = $request->input('rate') ?? $book->rate;
        $book->publish_date  = $request->input('publish_date') ?? $book->publish_date;
        $book->copies_number = $request->input('copies_number') ?? $book->copies_number;

        $book->save();
        $data = new BookResource($book);
        return $this->customeResponse($data, 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->authors()->detach();
        $book->users()->detach();
        $book->delete();
        return response()->json(['message' => 'Book Deleted'], 200);
    }
}
