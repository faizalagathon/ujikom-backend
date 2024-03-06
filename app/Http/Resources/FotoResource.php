<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal,
            'file' => $this->file,
            'album_id' => $this->album_id,
            'user_id' => $this->user_id,
            'likes' => LikeCollection::make($this->whenLoaded('likes')),
        ];
    }
}
