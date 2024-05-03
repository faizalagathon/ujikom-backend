<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumStoreRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Http\Resources\AlbumCollection;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AlbumController extends Controller
{
    public function index(Request $request, $idUser)
    {
        $albums = Album::where('user_id', $idUser)->get();

        if ($albums->isEmpty()){
            return response()->json(['status' => false]);
        }

        return new AlbumCollection($albums);
    }

    public function store(AlbumStoreRequest $request)
    {
        $album = Album::create($request->validated());

        return new AlbumResource($album);
    }

    // public function show(Request $request, Album $album)
    // {
    //     return new AlbumResource($album);
    // }

    public function update(AlbumUpdateRequest $request, $idAlbum)
    {
        $album = Album::find($idAlbum);

        $album->update($request->validated());

        return new AlbumResource($album);
    }

    public function destroy(Request $request, $idAlbum)
    {
        $album = Album::find($idAlbum);

        if ($album) {
            $album->delete();
            return response()->json(['status' => true]);
        }

        return response()->json(['message' => 'Album not found'], 404);
    }
}
