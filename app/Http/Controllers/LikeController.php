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
    public function toggleLike(Request $request)
    {
        $like = Like::where('user_id', $request->id_user)
                    ->where('foto_id', $request->id_foto)
                    ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Unlike berhasil'], 200);
        } else {
            $like = new Like;
            $like->user_id = $request->id_user;
            $like->foto_id = $request->id_foto;
            $like->tanggal = date('Y-m-d');
            $like->save();
            return response()->json(['message' => 'Like berhasil'], 200);
        }
    }

    public function checkLike($id_user, $id_foto)
    {
        $like = Like::where('user_id', $id_user)
                    ->where('foto_id', $id_foto)
                    ->first();

        if ($like) {
            return response()->json(['status' => true], 200);
        } else {
            return response()->json(['status' => false], 200);
        }
    }
}
