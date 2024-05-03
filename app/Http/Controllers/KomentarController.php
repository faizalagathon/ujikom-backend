<?php

namespace App\Http\Controllers;

use App\Http\Requests\KomentarStoreRequest;
use App\Http\Requests\KomentarUpdateRequest;
use App\Http\Resources\KomentarCollection;
use App\Http\Resources\KomentarResource;
use App\Models\Komentar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KomentarController extends Controller
{
    public function store(KomentarStoreRequest $request)
    {
        $validatedData = $request->validated();
        $tanggal = Carbon::now();
        $validatedData['tanggal'] = $tanggal;

        $komentar = Komentar::create($validatedData);

        return new KomentarResource($komentar);
    }


    public function destroy($id)
    {
        $komentar = Komentar::find($id);
        if (!$komentar) {
            return response()->json(['status' => false, 'message' => 'Komentar tidak ditemukan'], 404);
        }
        $komentar->delete();

        return response()->json(['status' => true, 'message' => 'Komentar berhasil dihapus']);
    }

}
