<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get all unique current 'lokasi' values from existing Barangs
        //    (excluding nulls)
        $uniqueLocations = Barang::whereNotNull('lokasi')
            ->distinct()
            ->pluck('lokasi');

        foreach ($uniqueLocations as $locName) {
            // 2. Create Room if not exists
            $room = Room::firstOrCreate(
                ['nama' => $locName],
                ['keterangan' => 'Migrated from legacy location data']
            );

            // 3. Update Barangs to point to this Room
            Barang::where('lokasi', $locName)
                ->update(['room_id' => $room->id]);
        }
    }
}
