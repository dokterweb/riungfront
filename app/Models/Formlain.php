<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formlain extends Model
{
    use HasFactory;

    protected $table = 'formlains';

    // Tentukan kolom yang bisa diisi
    protected $fillable=['worker_id','formlain_file','tgl_mintaform','keterangan'];

    // Relasi dengan model Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
