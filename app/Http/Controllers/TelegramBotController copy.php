<?php

namespace App\Http\Controllers;

use App\Models\Bpjs;
use Telegram\Bot\Api;
use App\Models\Etiket;
use App\Models\Worker;
use App\Models\SuratTugas;
use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramBotController extends Controller
{

    public function handleWebhook(Request $request)
{
    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    $update = $telegram->getWebhookUpdate();

    // Jika update berisi callback_query
    if ($update->has('callback_query')) {
        $callbackQuery = $update->getCallbackQuery();
        $chatId = $callbackQuery->getFrom()->getId();
        $callbackData = $callbackQuery->getData();

        Log::info('CallbackQuery diterima dari chat_id: ' . $chatId . ' dengan data: ' . $callbackData);

        // Cek apakah user sudah terverifikasi
        $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();

        if ($telegramUser) {
            $worker = $telegramUser->worker()->with('user')->first();

            if ($worker) {
                // Menangani callback 'bpjs'
                if ($callbackData == 'bpjs') {
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Anda berada di menu BPJS. Mengambil data terkait...",
                    ]);

                    $bpjs = Bpjs::where('worker_id', $worker->id)->first();

                    // Log data BPJS
                    Log::info('Data BPJS ditemukan: ', ['bpjs' => $bpjs]);

                    if ($bpjs) {
                        $message = "Berikut adalah data BPJS Anda:\n";
                        $message .= "Tenaga Kerja: {$bpjs->tenagakerja_file}\n";
                        $message .= "Kesehatan: {$bpjs->kesehatan_file}\n";

                        $telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => $message,
                        ]);
                    } else {
                        $telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => "Tidak ada data BPJS yang ditemukan untuk Anda.",
                        ]);
                    }
                }
                // Menangani callback 'etiket'
                elseif ($callbackData == 'etiket') {
                    // Kirim pesan memberitahu user bahwa mereka berada di menu Etiket
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Anda berada di menu Etiket. Mengambil data terkait...",
                    ]);

                    // Ambil data Etiket
                    $etiket = Etiket::where('worker_id', $worker->id)->first();

                    Log::info('Data Etiket ditemukan: ', ['etiket' => $etiket]);

                    if ($etiket) {
                        // Format pesan Etiket
                        $message = "Berikut adalah tiket Etiket Anda:\n";
                        $message .= "Tiket: {$etiket->tiket_file}\n";
                        $message .= "Tanggal: {$etiket->tgl_tiket}\n";

                        $telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => $message,
                        ]);
                    } else {
                        $telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => "Tidak ada data Etiket yang ditemukan untuk Anda.",
                        ]);
                    }
                }
                elseif ($callbackData == 'surat_tugas') {
                    // Kirim pesan memberitahu user bahwa mereka berada di menu Etiket
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Anda berada di menu Surat Tugas. Mengambil data terkait...",
                    ]);

                    // Ambil data Etiket
                    $surat_tugas = SuratTugas::where('worker_id', $worker->id)->first();

                    Log::info('Data Surat Tugas ditemukan: ', ['surat_tugas' => $surat_tugas]);

                    if ($surat_tugas) {
                        // Format pesan Etiket
                        $message = "Berikut adalah tiket Surat Tugas Anda:\n";
                        $message .= "Surat Tugas: {$surat_tugas->surat_tugas_file	}\n";

                        $telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => $message,
                        ]);
                    } else {
                        $telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => "Tidak ada data Surat Tugas yang ditemukan untuk Anda.",
                        ]);
                    }
                }
                // Menangani callback untuk menu lain jika diperlukan
                else {
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Menu ini belum tersedia.",
                    ]);
                }
            }
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Anda belum terverifikasi, silakan kirim nomor HP Anda terlebih dahulu.",
            ]);
        }
    }
    // Jika update berisi message (pesan biasa)
    else if ($update->has('message')) {
        $message = $update->getMessage();
        if (!$message || !$message->getText()) {
            return response()->json(['status' => 'no_message']);
        }

        $text = $message->getText();
        $chatId = $message->getChat()->getId();

        Log::info('Pesan dari chat_id: ' . $chatId . ' dengan pesan: ' . $text);

        // Cek apakah chat_id sudah terdaftar
        $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();

        if ($telegramUser) {
            $worker = $telegramUser->worker()->with('user')->first();
            $name = $worker && $worker->user ? $worker->user->name : 'User';

            // Kirim menu setelah login berhasil
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Halo {$name}, pilih menu berikut:",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Surat Tugas', 'callback_data' => 'surat_tugas'],
                        ],
                        [
                            ['text' => 'BPJS', 'callback_data' => 'bpjs'],
                        ],
                        [
                            ['text' => 'Etiket', 'callback_data' => 'etiket'],
                        ]
                    ]
                ])
            ]);
        } else {
            // Jika belum terverifikasi, kirim pesan untuk verifikasi
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Mohon verifikasi nomor HP Anda terlebih dahulu.",
            ]);
        }
    }

    return response()->json(['status' => 'ok']);
}

    
    
    private function normalizePhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 2) == '62') {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }

  
    
}