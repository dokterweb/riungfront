<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiTahunan extends Model
{
    use HasFactory;

    protected $table = 'cuti_tahunans';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'worker_id',
        'jatahcuti',
        'sisacuti',
        'telahcuti',
    ];


      // Relasi dengan model Worker
      public function worker()
      {
          return $this->belongsTo(Worker::class);
      }
}
