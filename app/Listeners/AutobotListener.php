<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\AutobotCreatedEvent;
use App\Jobs\CreateAutobotJob;

class AutobotListener
{

    public function __construct()
    {
        // left for bravery
    }

    /**
     * Handle the event.
    */
    public function handle(AutobotCreatedEvent $event): void
    {
        
        CreateAutobotJob::dispatch($event->totalAutobots, $event->totalPosts, $event->totalComments);
    }
}
