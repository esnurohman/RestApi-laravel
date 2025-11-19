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