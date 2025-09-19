<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);

        return response()->json(new PostCollection($posts), Response::HTTP_OK);
    }

    public function store(PostRequest $request)
    {
        $post = Post::create([
            'user_id'   => Auth::id(),
            'title'     => $request->title,
            'content'   => $request->input('content'),
            'thumbnail' => $request->thumbnail,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Post berhasil dibuat',
            'data'    => new PostResource($post),
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);

        return response()->json([
            'status'  => true,
            'message' => 'Detail Post',
            'data'    => new PostResource($post),
        ], Response::HTTP_OK);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);

        $post->update($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Post berhasil diupdate',
            'data'    => new PostResource($post),
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        $post->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Post berhasil dihapus',
        ], Response::HTTP_OK);
    }
}
