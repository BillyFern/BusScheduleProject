<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kedatangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'bus_id',
        'waktu_kedatangan',
        'asal_id',
        'status'
    ];

    public function findBus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }
    public function findLokasi()
    {
        return $this->belongsTo(Lokasi::class, 'asal_id');
    }

    public function updateStatus()
    {
        dd($this->waktu_keberangkatan);
        $now = Carbon::now('Asia/Jakarta');
        $waktuKedatangan = Carbon::createFromFormat('H:i:s', $this->waktu_kedatangan, $now->timezone)
                                    ->setDate($now->year, $now->month, $now->day);

        if ($this->status == 2){ //status hanya akan otomatis diubah jika status berupa 0, 1, dan 2
            if($now->greaterThanOrEqualTo($waktuKedatangan)){
                $this->status = 1; //1 berarti sampai
            }
        }

        $this->save();
    }
}