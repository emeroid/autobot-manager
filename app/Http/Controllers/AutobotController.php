<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autobot;
use App\Models\Post;

class AutobotController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/autobots",
     *     tags={"Autobots"},
     *     summary="Get list of Autobots",
     *     description="Returns a paginated list of Autobots",
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="The number of results to return per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Autobot")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        return Autobot::paginate($request->limit || 10);
    }

    /**
     * @OA\Get(
     *     path="/api/autobots/{id}",
     *     tags={"Autobots"},
     *     summary="Get Autobot details",
     *     description="Returns details of a specific Autobot",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Autobot to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(ref="#/components/schemas/Autobot")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Autobot not found"
     *     )
     * )
     */
    public function show(Request $request)
    {
        $autobot = Autobot::findOrFail($request->id);
        if (!$autobot) {
            ['message' => 'Autobot not found!'];
        }

        return $autobot;
    }

    /**
     * @OA\Get(
     *     path="/api/autobots/{id}/posts",
     *     tags={"Autobots"},
     *     summary="Get posts of a specific Autobot",
     *     description="Returns a paginated list of posts for a specific Autobot",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Autobot",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Post")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function posts(Request $request)
    {
        return Post::where('autobot_id', $request->autobotId)->paginate(10);
    }
}

