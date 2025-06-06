<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramBotController;


Route::post('/telegram/webhook', [TelegramBotController::class, 'handleWebhook']);
Route::post('/telegram/callback', [TelegramBotController::class, 'handleCallback']);

/* Route::get('/telegram/test', function () {
    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    $chatId = '@dokterwebID'; // ganti dengan chat ID Anda (bisa dapat dari log)

    try {
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Tes kirim pesan dari route test",
        ]);
        return 'Pesan terkirim';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
