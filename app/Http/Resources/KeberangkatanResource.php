<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class KeberangkatanResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'bus' => new BusResource($this->findBus),
            'waktu_keberangkatan' => (new Carbon($this->waktu_keberangkatan))->format('H:i'),
            'tujuan' => new LokasiResource($this->findLokasi),
            'status' => $this->status,
            'bus_id' => $this->bus_id,
            'tujuan_id' => $this->tujuan_id
        ];
    }
}
