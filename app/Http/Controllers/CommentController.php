<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::query()->get();

        return new JsonResponse([
            'data'=> $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $created = Comment::query()->create([
            'body' => $request->body,
        ]);

        $created = DB::transaction(function () use ($request) {
            $created = Comment::query()->create([
                'body' => $request->body,
            ]);

            if ($userIds = $request->user_ids) {
                $created->users()->sync($userIds);
            }
            return $created;
        });

        return new CommentResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $updated = $comment->update($request->only('title', 'body'));

        // $updated = $comment->update([
        //     'body' => $request->body ?? $post->body,
        // ]);

        if (!$updated) {
            return new JsonResponse([
                'errors' =>[
                    'Failed to update model'
                ]
                ], 400);
        }

        return new CommentResource($comment);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $deleted = $comment->forceDelete();

        if (!$deleted) {
            return new JsonResponse([
                'errors' => [
                    'Could not delete resource'
                ]
                ], 400);
        }
        return new JsonResponse([
            'data' => 'sucess'
        ]);
    }
}
