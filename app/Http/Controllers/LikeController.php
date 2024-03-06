<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeStoreRequest;
use App\Http\Requests\LikeUpdateRequest;
use App\Http\Resources\LikeCollection;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    public function index(Request $request): Response
    {
        $likes = Like::all();

        return new LikeCollection($likes);
    }

    public function store(LikeStoreRequest $request): Response
    {
        $like = Like::create($request->validated());

        return new LikeResource($like);
    }

    public function show(Request $request, Like $like): Response
    {
        return new LikeResource($like);
    }

    public function update(LikeUpdateRequest $request, Like $like): Response
    {
        $like->update($request->validated());

        return new LikeResource($like);
    }

    public function destroy(Request $request, Like $like): Response
    {
        $like->delete();

        return response()->noContent();
    }
}
