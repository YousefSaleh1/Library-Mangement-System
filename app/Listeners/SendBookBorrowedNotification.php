<?php

namespace App\Listeners;

use App\Events\BookBorrowed;
use App\Jobs\CreateNotificationJob;
use App\Jobs\SendEmailToAllUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookBorrowedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookBorrowed $event): void
    {
        $books = $event->books;

        $message = "The following books have been borrowed: [ ";

        foreach ($books as $book) {
            $message .= $book->title. ", ";
        }
        $message.= ' ]';
        CreateNotificationJob::dispatch($message);
        SendEmailToAllUsers::dispatch($message);
    }
}
