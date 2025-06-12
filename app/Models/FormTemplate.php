<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTemplate extends Model
{
    use HasFactory;
    protected $table = 'formtemplates';

    protected $fillable=['nama_file', 'form_file', 'keterangan'];
}
