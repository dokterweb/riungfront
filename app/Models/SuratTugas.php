<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

      // Tentukan tabel yang digunakan
      protected $table = 'surat_tugas';

      // Tentukan kolom yang bisa diisi
      protected $fillable = [
          'worker_id',
          'surat_tugas_file',
      ];
  
      // Relasi dengan model Worker
      public function worker()
      {
          return $this->belongsTo(Worker::class);
      }
}
