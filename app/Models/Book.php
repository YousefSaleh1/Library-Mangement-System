<?php

namespace App\Models;

use App\Http\Traits\Loggable;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Book extends Model
{
    use HasFactory, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'rate',
        'publish_date',
        'copies_number',
        'available',
    ];

    /**
     * The users that belong to the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'borrowers');
    }

    /**
     * The authors that belong to the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_book');
    }

    /**
     * Get all of the notes for the book.
     *
     * This function defines a polymorphic relationship between the book model and the note model,
     * allowing the book to have many notes associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Decreases the number of copies available for borrowing.
     *
     * If the number of copies reaches zero, the book's availability is set to false.
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function decreaseCopies()
    {
        $this->copies_number -= 1;
        if ($this->copies_number == 0) {
            $this->available = false;
        }
        $this->save();
    }

    public function increaseCopies()
    {
        if ($this->copies_number == 0) {
            $this->available = true;
        }
        $this->copies_number += 1;
        $this->save();
    }
}
