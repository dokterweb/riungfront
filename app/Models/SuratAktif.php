<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratAktif extends Model
{
    use HasFactory;

    protected $table = 'surat_aktifs';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'worker_id',
        'surat_aktif_file',
        'tgl_surat_aktif',
    ];

    // Relasi dengan model Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
