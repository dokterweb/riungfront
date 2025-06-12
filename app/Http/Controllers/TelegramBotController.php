<?php

namespace App\Http\Controllers;

use App\Models\Bpjs;
use App\Models\Gaji;
use Telegram\Bot\Api;
use App\Models\Etiket;
use App\Models\Worker;
use App\Models\Overtime;
use App\Models\Rapel_usl;
use App\Models\SuratAktif;
use App\Models\SuratTugas;
use App\Models\CutiTahunan;
use App\Models\FormTemplate;
use App\Models\SuratPromosi;
use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TelegramBotController extends Controller
{

    public function handleCallback($chatId, $callbackData, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        
        switch ($callbackData) {
            case 'bpjs':
                return $this->handleBpjs($chatId, $worker);
            case 'etiket':
                return $this->handleEtiket($chatId, $worker);
            case 'surat_tugas':
                return $this->handleSuratTugas($chatId, $worker);
            case 'surat_kerja':
                return $this->handleSuratKerja($chatId, $worker);
            case 'gaji':
                return $this->handleGaji($chatId, $worker);
            case 'overtime':
                return $this->handleOvertime($chatId, $worker);
            case 'rapel_usl':
                return $this->handleRapel_usl($chatId, $worker);
            case 'cutitahunan':
                return $this->handleCutiTahunan($chatId, $worker); 
            case 'formtemplate':
                return $this->handleFormTemplate($chatId, $worker); 
            case 'surataktif':
                return $this->handleSuratAktif($chatId, $worker); 
            case 'suratpromosi':
                return $this->handleSuratPromosi($chatId, $worker); 
            default:
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Menu ini belum tersedia.",
                ]);
                break;
        }
    }
    
    public function handleBpjs($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu BPJS. Mengambil data terkait...",
        ]);
    
        $bpjs = Bpjs::where('worker_id', $worker->id)->first();
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
    
    public function handleEtiket($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu Etiket. Mengambil data terkait...",
        ]);
    
        $etiket = Etiket::where('worker_id', $worker->id)->first();
        if ($etiket) {
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
    
    public function handleSuratTugas($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu Surat Tugas. Mengambil data terkait...",
        ]);
    
        $surat_tugas = SuratTugas::where('worker_id', $worker->id)->first();
        if ($surat_tugas) {
            $message = "Berikut adalah tiket Surat Tugas Anda:\n";
            $message .= "Surat Tugas: {$surat_tugas->surat_tugas_file}\n";
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

    public function handleSuratKerja($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu Surat Kerja. Mengambil data terkait...",
        ]);
    
        $surat_kerja = SuratTugas::where('worker_id', $worker->id)->first();
        if ($surat_kerja) {
            $message = "Berikut adalah tiket Surat Kerja Anda:\n";
            $message .= "Surat Kerja: {$surat_kerja->surat_kerja_file}\n";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Tidak ada data Surat Kerja yang ditemukan untuk Anda.",
            ]);
        }
    }
    
    public function handleGaji($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu Gaji. Mengambil data terkait...",
        ]);
    
        $gaji = Gaji::where('worker_id', $worker->id)->first();
        if ($gaji) {
            $message = "Berikut adalah Gaji Anda:\n";
            $message .= "File: {$gaji->nama_file}\n";
            $message .= "File: {$gaji->path_file}\n";
            $message .= "Periode: {$gaji->periode}\n";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Tidak ada data Gaji yang ditemukan untuk Anda.",
            ]);
        }
    }

    public function handleOvertime($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu overtime. Mengambil data terkait...",
        ]);
    
        $overtime = Overtime::where('worker_id', $worker->id)->first();
        if ($overtime) {
            $message = "Berikut adalah overtime Anda:\n";
            $message .= "File: {$overtime->nama_file}\n";
            $message .= "File: {$overtime->path_file}\n";
            $message .= "Periode: {$overtime->periode}\n";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Tidak ada data Gaji yang ditemukan untuk Anda.",
            ]);
        }
    }

    public function handleRapel_usl($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu Rapel USLS. Mengambil data terkait...",
        ]);
    
        $rapel_usl = Rapel_usl::where('worker_id', $worker->id)->first();
        if ($rapel_usl) {
            $message = "Berikut adalah Rapel USLS Anda:\n";
            $message .= "Total Hadir: {$rapel_usl->totalhadir}\n";
            $message .= "Tarif: {$rapel_usl->tarif}\n";
            $message .= "Rapelan: {$rapel_usl->rapelan}\n";
            $message .= "Total USL: {$rapel_usl->totalusl}\n";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Tidak ada data Rapel USLS yang ditemukan untuk Anda.",
            ]);
        }
    }

    public function handleSuratAktif($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu surat aktif. Mengambil data terkait...",
        ]);
    
        $surataktif = SuratAktif::where('worker_id', $worker->id)->first();
        if ($surataktif) {
            $message = "Berikut adalah surat aktif Anda:\n";
            $message .= "File: {$surataktif->surat_aktif_file}\n";
            $message .= "Periode: {$surataktif->tgl_surat_aktif}\n";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Tidak ada data Gaji yang ditemukan untuk Anda.",
            ]);
        }
    }

    public function handleSuratPromosi($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu surat tetap / promosi. Mengambil data terkait...",
        ]);
    
        $suratpromosi = SuratPromosi::where('worker_id', $worker->id)->first();
        if ($suratpromosi) {
            $formattedDate = Carbon::parse($suratpromosi->tgl_surat_tetap)->format('d-m-Y');

            $message = "Berikut adalah surat tetap / promosi Anda:\n";
            $message .= "File: {$suratpromosi->surat_tetap_file}\n";
            $message .= "Periode: {$formattedDate}\n";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Tidak ada data Gaji yang ditemukan untuk Anda.",
            ]);
        }
    }

    public function handleCutiTahunan($chatId, $worker)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Anda berada di menu Cuti Tahunan. Mengambil data terkait...",
        ]);
    
        $cuti = CutiTahunan::where('worker_id', $worker->id)->first();
        if ($cuti) {
            $message = "Berikut adalah Cuti Tahunan Anda:\n";
            $message .= "Jatah Cuti: {$cuti->jatahcuti}\n";
            $message .= "Sisa Cuti: {$cuti->sisacuti}\n";
            $message .= "Telah Cuti: {$cuti->telahcuti}\n";
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Tidak ada data Cuti Tahunan yang ditemukan untuk Anda.",
            ]);
        }
    }

    public function handleFormTemplate($chatId, $worker)
    {
        // Mengambil data formtemplates dari database
        $formTemplates = FormTemplate::all();
        
        // Menyiapkan pesan untuk mengirim ke Telegram
        $message = "Berikut adalah daftar formtemplates yang tersedia:\n\n";
        
        // Loop melalui setiap formTemplate dan menambahkannya ke pesan
        foreach ($formTemplates as $formTemplate) {
            $message .= "Nama Form: " . $formTemplate->nama_file . "\n";
            $message .= "File: " . $formTemplate->form_file . "\n";
            $message .= "Keterangan: " . $formTemplate->keterangan . "\n\n";
        }

        // Mengirimkan pesan ke Telegram
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message
        ]);
    }

    public function handleWebhook(Request $request)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $update = $telegram->getWebhookUpdate();
    
        if ($update->has('callback_query')) {
            $callbackQuery = $update->getCallbackQuery();
            $chatId = $callbackQuery->getFrom()->getId();
            $callbackData = $callbackQuery->getData();
    
            Log::info('CallbackQuery diterima dari chat_id: ' . $chatId . ' dengan data: ' . $callbackData);
    
            $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();
            if ($telegramUser) {
                $worker = $telegramUser->worker()->with('user')->first();
                if ($worker) {
                    return $this->handleCallback($chatId, $callbackData, $worker);
                }
            } else {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Anda belum terverifikasi, silakan kirim nomor HP Anda terlebih dahulu.",
                ]);
            }
        }
        else if ($update->has('message')) {
            $message = $update->getMessage();
            $chatId = $message->getChat()->getId();
            Log::info('Pesan dari chat_id: ' . $chatId . ' dengan pesan: ' . $message->getText());
    
            $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();
            if ($telegramUser) {
                $worker = $telegramUser->worker()->with('user')->first();
                $name = $worker && $worker->user ? $worker->user->name : 'User';
    
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Halo {$name}, pilih menu berikut:",
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => 'Surat Tugas', 'callback_data' => 'surat_tugas']],
                            [['text' => 'Surat Kerja', 'callback_data' => 'surat_kerja']],
                            [['text' => 'BPJS', 'callback_data' => 'bpjs']],
                            [['text' => 'Etiket', 'callback_data' => 'etiket']],
                            [['text' => 'Gaji', 'callback_data' => 'gaji']],
                            [['text' => 'Overtime', 'callback_data' => 'overtime']],
                            [['text' => 'Rapel USL', 'callback_data' => 'rapel_usl']],
                            [['text' => 'Cuti', 'callback_data' => 'cutitahunan']],
                            [['text' => 'Surat Aktif', 'callback_data' => 'surataktif']],
                            [['text' => 'Surat Tetap/Promsi', 'callback_data' => 'suratpromosi']],
                            [['text' => 'Form Template', 'callback_data' => 'formtemplate']],
                        ]
                    ])
                ]);
            } else {
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