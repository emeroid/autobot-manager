<?php

namespace App\Console\Commands;

use App\Events\AutobotCreatedEvent;
use App\Models\Autobot;
use Illuminate\Console\Command;



class CreateAutobots extends Command
{
    // Define the command signature with three optional arguments and default values
    protected $signature = 'autobots:create {autobots=500} {posts=10} {comments=10}';
    protected $description = 'Create a specified number of Autobots, posts, and comments';

    public function handle()
    {
        // Retrieve the arguments passed by the user, or use the default values
        $autobots = $this->argument('autobots');
        $posts = $this->argument('posts');
        $comments = $this->argument('comments');

        // Dispatch the event with the provided values
        AutobotCreatedEvent::dispatch($autobots, $posts, $comments);

        $this->info("Successfully created {$autobots} Autobots with {$posts} posts and {$comments} comments each.");
    }
}
