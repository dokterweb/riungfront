<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $table = 'telegram_users';

    protected $fillable = [
        'worker_id',
        'telegram_chat_id',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
