<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Telegram\Bot\Api;
use Illuminate\Http\Request;

class AdminController extends Controller
{
      // Fungsi untuk menyimpan chat_id admin
      public function storeAdminChatId($chatId)
      {
          // Menyimpan telegram_chat_id admin yang baru
          $admin = new Admin();
          $admin->telegram_chat_id = $chatId;  // Menyimpan ID chat Telegram
          $admin->save();
  
          // Mengirimkan pesan ke admin untuk konfirmasi
          $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
          $telegram->sendMessage([
              'chat_id' => $chatId,
              'text' => "Admin berhasil didaftarkan."
          ]);
      }
}
