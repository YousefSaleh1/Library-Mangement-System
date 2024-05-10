<?php

namespace App\Http\Traits;

use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;

trait GetReviewItemTrait
{
    public function getItem($reviewableType, $reviewableId)
    {

        switch ($reviewableType) {
            case 'App\Models\Book':
                $book = Book::findOrFail($reviewableId);
                return ['item_type' => 'Book',new BookResource($book)];
                break;
            case 'App\Models\Author':
                $author= Author::findOrFail($reviewableId);
                return ['item_type' => 'Author',new AuthorResource($author)];
                break;
            default:
                return 'Not Found!';
                break;
        }
    }
}
