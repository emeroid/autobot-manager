<?php

namespace App\Services;

use App\Events\AutobotCreatedEvent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Autobot;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\PostService;

class AutobotService
{
    protected $usedUsers = [];
    private PostService $postService;
    private CommentService $commentService;

    public function __construct(PostService $postService, CommentService $commentService)
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
    }

    public function createAutobots($total = 500, $totalPost = 10, $totalComment = 10)
    {
        $users = $this->fetchUsersFromApi();
        $comments = $this->fetchCommentsFromApi();
        $posts = $this->fetchPostsFromApi();

        for ($bot = 0; $bot < $total; $bot++) {
            $uniquAutobot = $this->createUniqueUser($users, $bot);

            $autobot = Autobot::create([
                'name' => $uniquAutobot['name'],
                'email' => $uniquAutobot['email'],
                'username' => $uniquAutobot['username'],
            ]);
            
            for ($botPost = 0; $botPost < $totalPost; $botPost++) {
                // Create the post for the Autobot
                $post = $this->postService->createPostForAutobot($autobot, $botPost, $posts);
    
                // Ensure the post was successfully created before creating comments
                if ($post) {
                    // Create 10 unique comments for this post
                    for ($postComment = 0; $postComment < $totalComment; $postComment++) {
                        $this->commentService->createCommentForAutobot($post, $postComment, $comments);
                    }
                } else {
                    Log::error("Failed to create post for Autobot with ID {$autobot->id}");
                }
            }
        }
    }

    private function fetchUsersFromApi()
    {
        // Fetch Autobots from the database
        $autobots = Autobot::first();

        if ($autobots !== null) {

            return $this->generateRandomUsers();

        } else {
            // If no comments in DB, fetch from the API
            $response = Http::get(env('BASE_API_URL') . '/users');
            return $response->json();
        }
    }

    private function fetchCommentsFromApi()
    {
        // Fetch comments from the database
        $comments = Comment::first();

        if ($comments !== null) {

            // If no comments in DB, fetch from the API
            return $this->generateRandomComments();

        } else {

            $response = Http::get(env('BASE_API_URL') . '/comments');
            return $response->json();
        }
        
    }

    private function fetchPostsFromApi()
    {
        // Fetch Autobots from the database
        $posts = Post::first();

        if ($posts !== null) {

            // If no comments in DB, fetch from the API
            return $this->generateRandomPosts();

        } else {

            $response = Http::get(env('BASE_API_URL') . '/posts');
            return $response->json();
            
        }

        
    }

    private function createUniqueUser($users, $index)
    {
         // Ensure that the posts array is not empty
        if (empty($users)) {
            // Optionally, log an error or handle this case accordingly
            Log::error("No Autobot found");
            return null;  // Skip processing if no posts are available
        }

        // Reuse users but modify them slightly for uniqueness
        $baseUser = $users[$index % count($users)];

        // Check if this user has already been used, if so, modify it
        while (in_array($baseUser['id'], $this->usedUsers)) {
            $baseUser['id'] = $this->generateNewId($baseUser['id']);
            $baseUser['username'] = $this->generateUniqueUsername($baseUser['username'], $index);
            $baseUser['email'] = $this->generateUniqueEmail($baseUser['email'], $index);
        }

        // Mark user as used
        $this->usedUsers[] = $baseUser['id'];

        return $baseUser;
    }

    private function generateNewId($currentId)
    {
        return $currentId + rand(1, 1000); // Just an example, generate a new unique ID
    }

    private function generateUniqueUsername($username, $index)
    {
        return $username . '_' . uniqid() . $index; // Add index or random number to username
    }

    private function generateUniqueEmail($email, $index)
    {
        // Extract the local part (before '@') and domain part (after '@')
        $emailParts = explode('@', $email);
        
        // Append the unique index or other unique data to the local part
        return $emailParts[0] . '_' . uniqid() . $index . '@' . $emailParts[1];
    }

    private function generateRandomUsers()
    {
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                'id' => $i + rand(1, 999999999), // Generate a random unique ID
                'name' => 'User' . uniqid(),
                'username' => 'user_' . uniqid(),
                'email' => 'user_' . $i . uniqid() . '@example.com',
            ];
        }
        return $users;
    }

    private function generateRandomPosts()
    {
        $posts = [];
        for ($i = 0; $i < 10; $i++) {
            $posts[] = [
                'id' => $i + rand(1, 999999999),
                'user_id' => rand(1, 999999999), // Random user ID
                'title' => 'Post title ' . uniqid(),
                'body' => 'Post content ' . uniqid(),
            ];
        }
        return $posts;
    }

    private function generateRandomComments()
    {
        $comments = [];
        for ($i = 0; $i < 5; $i++) {
            $comments[] = [
                'id' => $i + 1000,
                'post_id' => rand(1, 999999999), // Random post ID
                'name' => 'Comment Name ' . uniqid(),
                'body' => 'Comment body ' . uniqid(),
                'email' => 'commenter_' . $i . uniqid() . '@emeroid.com',
            ];
        }
        return $comments;
    }
    
}
