<?php

namespace App\Listeners;

use App\Events\BookReturned;
use App\Jobs\CreateNotificationJob;
use App\Jobs\SendEmailToAllUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookReturnedNotification
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
    public function handle(BookReturned $event): void
    {
        $books = $event->books;

        $message = "The following books have been returned: [ ";

        foreach ($books as $book) {
            $message .= $book->title. ", ";
        }
        
        $message.= ' ]';
        CreateNotificationJob::dispatch($message);
        SendEmailToAllUsers::dispatch($message);
    }
}
