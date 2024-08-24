<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     title="Post",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="autobot_id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Post Title"),
 *     @OA\Property(property="body", type="string", example="Post content"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
*/

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'autobot_id'
    ];

    public function autobot()
    {
        return $this->belongsTo(Autobot::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
