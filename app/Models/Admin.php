<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

     // Jika nama tabel tidak mengikuti konvensi penamaan Laravel (admins), kita bisa mendeklarasikan nama tabel secara eksplisit.
     protected $table = 'admins';

     // Tentukan kolom mana yang bisa diisi (mass assignable)
     protected $fillable = [
         'telegram_chat_id',
     ];
 
     // Jika kamu ingin mengatur waktu pembuatan dan pembaruan secara otomatis
     public $timestamps = true;
}
