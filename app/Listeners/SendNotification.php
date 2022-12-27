<?php

namespace App\Listeners;

use App\Events\NorifyUser;
use App\Events\NotifyUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNotification implements ShouldQueue
{
    public $tries = 5;

    /**
     * Handle the event.
     *
     * @param NotifyUser $event
     * @return void
     */
    public function handle(NotifyUser $event)
    {
        Log::info("user {$event->user->email} has been notified");
    }
}
