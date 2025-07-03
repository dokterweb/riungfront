<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Suratlain extends Model
{
    use HasFactory;

    protected $table = 'suratlains';

    // Tentukan kolom yang bisa diisi
    protected $fillable=['worker_id','suratlain_file','tgl_mintasurat','keterangan'];

    // Relasi dengan model Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
