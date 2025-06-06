<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
      // Tentukan tabel yang digunakan
      protected $table = 'gajis';

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
