<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table = 'workers';

    protected $fillable = [
        'user_id', 'no_hp', 'jabatan', 'departemen', 'tempat_lahir', 'tanggal_lahir',
        'tgl_masuk_kerja', 'staff', 'is_active', // dan kolom lain sesuai tabel
    ];

    // Jika tidak memakai timestamps otomatis
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
