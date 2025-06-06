<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapel_usl extends Model
{
    use HasFactory;

    protected $table = 'rapel_usls';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'worker_id',
        'totalhadir',
        'tarif',
        'rapelan',
        'totalusl',
    ];

    // Relasi dengan model Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
