<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bpjs extends Model
{
    use HasFactory;
    protected $table = 'bpjs'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'worker_id',         // kolom worker_id
        'tenagakerja_file',  // kolom tenagakerja_file
        'kesehatan_file',    // kolom kesehatan_file
    ];

    // Relasi dengan worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
