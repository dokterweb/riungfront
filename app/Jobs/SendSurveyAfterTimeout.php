<?php

namespace App\Jobs;

use App\Models\Worker;
use Telegram\Bot\Api; 
use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSurveyAfterTimeout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chatId;

    public function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    public function handle()
    {
        // Dapatkan waktu interaksi terakhir
        $lastInteraction = Cache::get('last_interaction_'.$this->chatId);
        
        if (!$lastInteraction) {
            Log::info("Tidak ada data interaksi untuk chat_id: ".$this->chatId);
            return;
        }
    
        $diffInSeconds = now()->diffInSeconds($lastInteraction);
        Log::info("Selisih waktu untuk chat_id {$this->chatId}: {$diffInSeconds} detik");
    
        // Jika sudah lebih dari 5 detik tidak ada interaksi
        if ($diffInSeconds >= 5) {
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            
            try {
                $telegram->sendMessage([
                    'chat_id' => $this->chatId,
                    'text' => "Silakan beri penilaian Anda:",
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                ['text' => '😡', 'callback_data' => 'survey_1'],
                                ['text' => '😞', 'callback_data' => 'survey_2'],
                                ['text' => '😐', 'callback_data' => 'survey_3'],
                                ['text' => '😊', 'callback_data' => 'survey_4'],
                                ['text' => '😁', 'callback_data' => 'survey_5']
                            ]
                        ]
                    ])
                ]);
                Log::info("Survey berhasil dikirim ke chat_id: ".$this->chatId);
            } catch (\Exception $e) {
                Log::error("Gagal mengirim survey ke chat_id {$this->chatId}: ".$e->getMessage());
            }
        } else {
            Log::info("User masih aktif, survey dibatalkan untuk chat_id: ".$this->chatId);
        }
    }
    
}
