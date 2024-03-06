<?php

namespace App\Http\Controllers;

use App\Http\Requests\KomentarStoreRequest;
use App\Http\Requests\KomentarUpdateRequest;
use App\Http\Resources\KomentarCollection;
use App\Http\Resources\KomentarResource;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KomentarController extends Controller
{
    public function index(Request $request): Response
    {
        $komentars = Komentar::all();

        return new KomentarCollection($komentars);
    }

    public function store(KomentarStoreRequest $request): Response
    {
        $komentar = Komentar::create($request->validated());

        return new KomentarResource($komentar);
    }

    public function show(Request $request, Komentar $komentar): Response
    {
        return new KomentarResource($komentar);
    }

    public function update(KomentarUpdateRequest $request, Komentar $komentar): Response
    {
        $komentar->update($request->validated());

        return new KomentarResource($komentar);
    }

    public function destroy(Request $request, Komentar $komentar): Response
    {
        $komentar->delete();

        return response()->noContent();
    }
}
