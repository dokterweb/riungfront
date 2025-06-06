<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiket extends Model
{
    use HasFactory;

     // Tentukan tabel yang digunakan
     protected $table = 'etikets';

     // Tentukan kolom yang bisa diisi
     protected $fillable = [
         'worker_id',
         'tiket',
         'tgl_tiket',
     ];
 
     // Relasi dengan model Worker
     public function worker()
     {
         return $this->belongsTo(Worker::class);
     }
}
