<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class KedatanganResource extends JsonResource
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
            'waktu_kedatangan' => (new Carbon($this->waktu_kedatangan))->format('H:i'),
            'asal' => new LokasiResource($this->findLokasi),
            'status' => $this->status,
            'bus_id' => $this->bus_id,
            'asal_id' => $this->asal_id
        ];
    }
}
