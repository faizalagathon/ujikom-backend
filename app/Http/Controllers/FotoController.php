<?php

namespace App\Http\Controllers;

use App\Http\Requests\FotoStoreRequest;
use App\Http\Requests\FotoUpdateRequest;
use App\Http\Resources\FotoCollection;
use App\Http\Resources\FotoResource;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function getFoto($file)
    {
        return Storage::get('public/foto/' . $file);
    }
    public function index()
    {
        $data = Foto::all();

        if ($data->isEmpty()) {
            return response()->json(['status' => false]);
        }

        return response()->json(['status' => true, 'data' => FotoResource::collection($data)]);
    }

    public function showFotoAlbum($idAlbum)
    {
        $data = Foto::where('album_id', $idAlbum)->get();

        if ($data->isEmpty()) {
            return response()->json(['status' => false]);
        }

        return response()->json(['status' => true, 'data' => FotoResource::collection($data)]);
    }

    public function store(FotoStoreRequest $request)
    {
        $foto = Foto::create($request->validated());

        Storage::put('public/foto/', $request->foto);

        return new FotoResource($foto);
    }

    public function show(Request $request, Foto $foto)
    {
        return new FotoResource($foto);
    }

    public function update(FotoUpdateRequest $request, Foto $foto)
    {
        $foto->update($request->validated());

        return new FotoResource($foto);
    }

    public function destroy(Request $request, Foto $foto)
    {
        $foto->delete();

        return response()->noContent();
    }
}
