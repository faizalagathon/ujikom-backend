<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'foto_id' => $this->foto_id,
            'user_id' => $this->user_id,
            'tanggal' => $this->tanggal,
        ];
    }
}
