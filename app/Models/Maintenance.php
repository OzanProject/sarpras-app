<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Support\Carbon $tgl_lapor
 * @property \Illuminate\Support\Carbon|null $tgl_selesai
 */
class Maintenance extends Model
{
    protected $fillable = [
        'barang_id',
        'tgl_lapor',
        'deskripsi_kerusakan',
        'biaya',
        'tgl_selesai',
        'status',
    ];

    protected $casts = [
        'tgl_lapor' => 'date',
        'tgl_selesai' => 'date',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
