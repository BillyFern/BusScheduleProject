<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use App\Models\Kedatangan;

class UpdateJadwalStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jadwal:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status jadwal berdasarkan waktu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jadwals = Jadwal::all();
        $kedatangans = Kedatangan::all();

        foreach($jadwals as $jadwal){
            $jadwal->updateStatus();
        }

        foreach($kedatangans as $kedatangan){
            $kedatangan->updateStatus();
        }

        $this->info('Jadwal statuses updated successfully');
    }
}
