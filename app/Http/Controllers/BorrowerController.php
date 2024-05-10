<?php

namespace App\Http\Controllers;

use App\Http\Requests\Borrower\BorrowerRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\BookManagementTrait;

class BorrowerController extends Controller
{
    use ApiResponseTrait, BookManagementTrait;

    /**
     * Attach books to a user.
     *
     * @param  BorrowerRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrowerBook(BorrowerRequest $request)
    {
        $books = $this->attachBooksToUser($request);
        return $this->customeResponse($books, 'Books attached to user successfully', 200);
    }

    /**
     * Detach books from a user.
     *
     * @param  BorrowerRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnBook(BorrowerRequest $request)
    {
        $books = $this->detachBooksFromUser($request);
        return $this->customeResponse($books, 'Books detached from user successfully', 200);
    }
}
