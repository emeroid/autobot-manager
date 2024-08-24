<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Autobot",
 *     type="object",
 *     title="Autobot",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Autobot Name"),
 *     @OA\Property(property="email", type="string", example="autobot@example.com"),
 *     @OA\Property(property="username", type="string", example="autobot123"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class Autobot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'username',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
