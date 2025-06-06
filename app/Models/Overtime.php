<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $table = 'overtimes';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'worker_id',
        'nama_file',
        'path_file',
        'periode',
    ];

    // Relasi dengan model Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
