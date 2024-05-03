<?php

namespace App\Http\Controllers;

use App\Http\Requests\FotoStoreRequest;
use App\Http\Requests\FotoUpdateRequest;
use App\Http\Resources\FotoCollection;
use App\Http\Resources\FotoResource;
use App\Models\Foto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function getFoto($file)
    {
        return Storage::get('public/foto/' . $file);
    }
    public function getFotoById($id)
    {
        $foto = Foto::find($id);
        if (!$foto) {
            return response()->json(['status' => false, 'message' => 'Foto tidak ditemukan'], 404);
        }
        return Storage::get('public/foto/' . $foto->file);
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
        $validatedData = $request->validated();

        $tanggal = Carbon::parse($validatedData['tanggal'])->toDateTimeString();

        // Tambahkan tanggal yang sudah diformat ke dalam data yang akan disimpan
        $validatedData['tanggal'] = $tanggal;

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('public/foto', $fileName);

        $validatedData['file'] = $fileName;

        $foto = Foto::create($validatedData);

        return new FotoResource($foto);
    }

    public function show($id)
    {
        $foto = Foto::with('komentars', 'likes')->find($id);
        if (!$foto) {
            return response()->json(['status' => false, 'message' => 'Foto tidak ditemukan'], 404);
        }
        $jumlahLikes = $foto->likes->count();
        $komentars = $foto->komentars;
        return response()->json(['status' => true, 'data' => $foto, 'jumlahLike' => $jumlahLikes, 'komentar' => $komentars]);
    }
    public function update(FotoUpdateRequest $request, $idFoto)
    {
        $foto = Foto::find($idFoto);
        $foto->update($request->validated());

        return new FotoResource($foto);
    }

    public function destroy(Request $request, $idFoto)
    {
        $foto = Foto::find($idFoto);
        $foto->delete();

        return response()->json(['status' => true]);
    }
}
