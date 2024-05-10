<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;;

use App\Http\Resources\ReviewResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        $data    = ReviewResource::collection($reviews);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a new review for the book.
     *
     * @param  StoreReviewRequest  $request
     * @param  Book  $book
     * @return \Illuminate\Http\Response
     */
    public function bookStore(StoreReviewRequest $request, Book $book)
    {
        $review = $book->reviews()->create([
            'review' => $request->review,
            'rate'   => $request->rate
        ]);
        $data = new ReviewResource($review);
        return $this->customeResponse($data, 'Created Successfully', 201);
    }

    /**
     * Store a new review for the author.
     *
     * @param  StoreReviewRequest  $request
     * @param  Author  $author
     * @return \Illuminate\Http\Response
     */
    public function authorStore(StoreReviewRequest $request, Author $author)
    {
        $review = $author->reviews()->create([
            'review' => $request->review,
            'rate'   => $request->rate
        ]);
        $data = new ReviewResource($review);
        return $this->customeResponse($data, 'Created Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $data = new ReviewResource($review);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $review->review = $request->input('review') ?? $review->review;
        $review->rate   = $request->input('rate') ?? $review->rate;

        $review->save();
        $data = new ReviewResource($review);
        return $this->customeResponse($data, 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(['message' => 'Review Deleted'], 200);
    }
}
