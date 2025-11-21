<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     tags={"Posts"},
     *     security={{ "bearerAuth":{} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of posts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Judul Post"),
     *                 @OA\Property(property="content", type="string", example="Isi post"),
     *                 @OA\Property(property="status", type="integer", example=1)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        // ambil data terakhir post dari database melalui model Post
        $posts = Post::latest()->get();

        // return response json
        return response()->json([
            'data' => PostResource::collection($posts),
            'message' => 'Success fetch all posts',
            'status' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Buat Post baru",
     *     description="Membuat postingan terbaru",
     *     security={{"bearerAuth":{}}},
     *     tags={"Posts"},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"title", "content", "status"},
     *                 @OA\Property(property="title", type="string", example="Judul Post"),
     *                 @OA\Property(property="content", type="string",  example="Content Post"),
     *                 @OA\Property(property="status", type="integer",  example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Judul Post"),
     *                 @OA\Property(property="content", type="string", example="Content Post"),
     *                 @OA\Property(property="status", type="integer", example=1),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="content", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="status", type="array", @OA\Items(type="integer"))
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status' => false
            ]);
        }
         $post = Post::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('title'))
        ]);

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get single post",
     *     tags={"Posts"},
     *     security={{ "bearerAuth":{} }},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID post",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Post detail",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Judul Post"),
     *             @OA\Property(property="content", type="string", example="Isi post"),
     *             @OA\Property(property="slug", type="string", example="isi-post"),
     *             @OA\Property(property="status", type="integer", example=1)
     *         )
     *     ),
     * 
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function show(Post $post)
    {
        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Data post found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Perbarui Post baru",
     *     description="Perbarui postingan terbaru",
     *     security={{"bearerAuth":{}}},
     *     tags={"Posts"},
     * @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID of the post to update",
    *         @OA\Schema(type="integer", example=1)
    *     ),
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"title", "content", "status"},
     *                 @OA\Property(property="title", type="string", example="Judul Post"),
     *                 @OA\Property(property="content", type="string",  example="Content Post"),
     *                 @OA\Property(property="status", type="integer",  example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post berhasil diperbarui",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Judul Post"),
     *                 @OA\Property(property="content", type="string", example="Content Post"),
     *                 @OA\Property(property="status", type="integer", example=1),
     *             ),
     *         )
     *     ),
     * 
     * @OA\Response(
 *         response=401,
 *         description="Unauthorized - No valid Bearer token provided"
 *     ),
 * 
     * @OA\Response(
 *         response=404,
 *         description="Post not found"
 *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="content", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="status", type="array", @OA\Items(type="integer"))
     *         )
     *     )
     * )
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status' => false
            ]);
        }

        $post->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('title'))
        ]);

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post updated successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete post",
     *     tags={"Posts"},
     *     security={{ "bearerAuth":{} }},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID post",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Post deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Post deleted successfully")
     *         )
     *     ),
     *
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'data' => [],
            'message' => "Post deleted successfully.",
            'success' => true
        ]);
    }
}