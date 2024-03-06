<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal,
            'user_id' => $this->user_id,
            'fotos' => FotoCollection::make($this->whenLoaded('fotos')),
        ];
    }
}
