<?php

namespace App\Listeners;

use App\Events\BookAdded;
use App\Jobs\CreateNotificationJob;
use App\Jobs\SendEmailToAllUsers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookAddedNotification
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
    public function handle(BookAdded $event): void
    {
        $message = "A new book titled '{$event->book->title}' has been added to the library.";
        CreateNotificationJob::dispatch($message);
        SendEmailToAllUsers::dispatch($message);

    }
}
