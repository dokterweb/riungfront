<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';

    // Tentukan kolom yang bisa diisi
    protected $fillable=['worker_id','survey_option'];

    // Relasi dengan model Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
