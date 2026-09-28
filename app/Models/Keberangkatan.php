<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Keberangkatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'bus_id',
        'waktu_keberangkatan',
        'tujuan_id',
        'status'
    ];

    public function findBus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }
    public function findLokasi()
    {
        return $this->belongsTo(Lokasi::class, 'tujuan_id');
    }

    public function updateStatus()
    {
        dd($this->waktu_keberangkatan);
        $now = Carbon::now('Asia/Jakarta');
        $waktuKeberangkatan = Carbon::createFromFormat('H:i:s', $this->waktu_keberangkatan, $now->timezone)
                                    ->setDate($now->year, $now->month, $now->day);

        Log::info('Now: ' . $now->toDateTimeString());
        Log::info('Waktu Keberangkatan: ' . $waktuKeberangkatan->toDateTimeString());

        if ($this->status <= 2){ //status hanya akan otomatis diubah jika status berupa 0, 1, dan 2
            if($now->diffInMinutes($waktuKeberangkatan, false) <= 2 && $now->lessThan($waktuKeberangkatan)){
                $this->status = 0; //0 berarti Panggilan terakhir
            } elseif ($now->diffInMinutes($waktuKeberangkatan, false) <= 15 && $now->lessThan($waktuKeberangkatan)) {
                $this->status = 1; //1 berarti Dibuka
            } elseif ($now->greaterThanOrEqualTo($waktuKeberangkatan)) {
                $this->status = 4; //4 berarti telah berangkat
            }
        }

        $this->save();
    }

}