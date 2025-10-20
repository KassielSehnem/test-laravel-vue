<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user');
        $limit = (int) $request->query('limit', 10);

        if ($userId = $request->query('user_id')) {
            $posts->where('user_id', $userId);
        }
        
        $paginatedPosts = $posts->orderBy('id', 'DESC')->cursorPaginate($limit);

        return response()->json([
            'data' => PostResource::collection($paginatedPosts),
            'next_cursor' => $paginatedPosts->nextCursor()?->encode(),
            'has_more' => $paginatedPosts->hasMorePages()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = Post::create([
            'user_id' => $request->user()->id,
            ...$validated
        ]);
        
        return response()->json(PostResource::make($post->load('user')), Response::HTTP_CREATED);
    }

    //Devolve quais usuários podem criar posts para o filtro de postagens
    public function canPost()
    {
        return response()->json(UserResource::collection(User::where('is_admin', true)->get()));
    }
}
