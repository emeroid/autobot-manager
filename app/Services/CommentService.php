<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\PostService;

class CommentService
{
    protected $usedComments = [];

    public function createCommentForAutobot($post, $index, $comments)
    {
        // $comments = $this->fetchCommentsFromApi($post->id);
        // Reuse comments but modify them slightly for uniqueness
        $baseComment = $comments[$index % count($comments)];

        // Check if this comment has already been used, if so, modify it
        while (in_array($baseComment['id'], $this->usedComments)) {
            $baseComment['id'] = $this->generateNewId($baseComment['id']);
            $baseComment['name'] = $this->generateUniqueName($baseComment['name'], $index);
            $baseComment['body'] = $this->generateUniqueBody($baseComment['body'], $index);
        }

        // Mark comment as used
        $this->usedComments[] = $baseComment['id'];

        return $post->comments()->create([
            'name' => $baseComment['name'],
            'body' => $baseComment['body'],
            'email' => $baseComment['email']
        ]);
    }

    private function generateNewId($currentId)
    {
        return $currentId + rand(1, 1000); // generate a new unique ID
    }

    private function generateUniqueName($name, $index)
    {
        return $name . ' #' . $index; // Add index or random number to name
    }

    private function generateUniqueBody($body, $index)
    {
        return $body . ' [unique ' . $index . ']'; // Modify body to ensure uniqueness
    }
}
