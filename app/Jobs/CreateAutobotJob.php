<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\AutobotService;

class CreateAutobotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $totalAutobots;
    protected $totalComments;
    protected $totalPosts;

    public function __construct($totalAutobots, $totalComments, $totalPosts)
    {
        $this->totalAutobots = $totalAutobots;
        $this->totalComments = $totalComments;
        $this->totalPosts = $totalPosts;
    }

    public function handle(AutobotService $autobotService)
    {
        $autobotService->createAutobots($this->totalAutobots, $this->totalPosts, $this->totalComments);
    }
}
