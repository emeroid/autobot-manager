<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostService
{
    protected $usedPosts = [];

    public function createPostForAutobot($autobot, $index, $posts)
    {
        // Ensure that the posts array is not empty
        if (empty($posts)) {
            // Optionally, log an error or handle this case accordingly
            Log::error("No posts found for Autobot with ID {$autobot->id}");
            return null;  // Skip processing if no posts are available
        }

        // Reuse posts but modify them slightly for uniqueness
        $basePost = $posts[$index % count($posts)];

        // Check if this post has already been used, if so, modify it
        while (in_array($basePost['id'], $this->usedPosts)) {
            $basePost['id'] = $this->generateNewId($basePost['id']);
            $basePost['title'] = $this->generateUniqueTitle($basePost['title'], $index);
            $basePost['body'] = $this->generateUniqueBody($basePost['body'], $index);
        }

        // Mark post as used
        $this->usedPosts[] = $basePost['id'];

        // Create post for the Autobot
        return $autobot->posts()->create([
            'title' => $basePost['title'],
            'body' => $basePost['body'],
        ]);
    }

    private function generateUniqueTitle($title, $index)
    {
        return $title . ' - Post ' . $index; // Modify title to ensure uniqueness
    }

    private function generateUniqueBody($body, $index)
    {
        return $body . ' [unique ' . $index . ']'; // Modify body to ensure uniqueness
    }

    private function generateNewId($currentId)
    {
        return $currentId + rand(1, 1000); // Generate a new unique ID
    }
}
