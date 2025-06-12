<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPromosi extends Model
{
    use HasFactory;
    
    protected $table = 'surat_tetap_promosis';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'worker_id',
        'surat_tetap_file',
        'tgl_surat_tetap',
    ];

    // Relasi dengan model Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
