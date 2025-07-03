<?php

namespace App\Http\Controllers;

use App\Models\Bpjs;
use App\Models\Gaji;
use Telegram\Bot\Api;
use App\Models\Etiket;
use App\Models\Survey;
use App\Models\Worker;
use App\Models\Formlain;
use App\Models\Overtime;
use App\Models\Rapel_usl;
use App\Models\Suratlain;
use App\Models\SuratAktif;
use App\Models\SuratKerja;
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
            case 'surataktif':
                return $this->handleSuratAktif($chatId, $worker); 
            case 'suratpromosi':
                return $this->handleSuratPromosi($chatId, $worker); 

            case 'permintaan_surat':
                return $this->showPermintaanSurat($chatId);
            case 'requestsurat_lain':
                return $this->handleRequestSuratLain($chatId);
            case 'listsuratlain':
                return $this->handleSuratLainList($chatId);
            case 'permintaan_form':
                return $this->showPermintaanForm($chatId);
            case 'formsurattugas':
                return $this->handleFormSuratTugas($chatId, $worker); 
            case 'formdeklarasidinas':
                return $this->handleFormDeklarasiDinas($chatId, $worker); 
            case 'formcutibesar':
                return $this->handleFormCutiBesar($chatId, $worker); 
            case 'formizinluartanggungan':
                return $this->handleFormIzinLuarTanggungan($chatId, $worker); 
            case 'formubahrek':
                return $this->handleformUbahRekKaryawan($chatId, $worker); 
            case 'formkonsulmedis':
                return $this->handleformKonsultasiMedis($chatId, $worker); 
            case 'requestform_lain':
                return $this->handleRequestFormLain($chatId);
            // Menambahkan kasus untuk survey
            case 'survey':
                return $this->handleSurveyChoice($chatId);

            case 'survey_1':
            case 'survey_2':
            case 'survey_3':
            case 'survey_4':
            case 'survey_5':
                return $this->handleSurveyResponse($chatId, $callbackData);

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
    
        $surat_kerja = SuratKerja::where('worker_id', $worker->id)->first();
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

    public function handleFormSuratTugas($chatId, $worker)
    {
        // Mengambil data formtemplate dengan id = 1
        $fsurattugas = FormTemplate::find(1);
    
        // Mengecek apakah formTemplate ditemukan
        if ($fsurattugas) {
            // Menyiapkan pesan untuk mengirim ke Telegram
            $message = "Berikut adalah form Pengajuan Surat Tugas:\n\n";
            $message .= "Nama Form: " . $fsurattugas->nama_file . "\n";
            $message .= "File: " . $fsurattugas->form_file . "\n";
            $message .= "Keterangan: " . $fsurattugas->keterangan . "\n\n";
    
            // Mengirimkan pesan ke Telegram
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message
            ]);
        } else {
            // Jika formTemplate tidak ditemukan
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Form template dengan ID 1 tidak ditemukan."
            ]);
        }
    }
   
    public function handleSuratLainList($chatId)
    {
        // Mengambil worker_id berdasarkan chat_id
        $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();
        
        // Pastikan user ditemukan
        if ($telegramUser) {
            // Mengambil data suratlain berdasarkan worker_id yang sesuai
            $suratLains = SuratLain::where('worker_id', $telegramUser->worker_id)->get();
            
            if ($suratLains->isEmpty()) {
                return response()->json([
                    'status' => 'no_data',
                    'message' => 'Tidak ada surat lain yang ditemukan.'
                ]);
            }

            // Jika data ditemukan, kirimkan ke pengguna
            $message = "Daftar Surat Lain:\n\n";
            foreach ($suratLains as $surat) {
                $message .= "Nama Surat: " . $surat->suratlain_file . "\n";
                $message .= "Keterangan: " . $surat->keterangan . "\n\n";
            }

            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message
            ]);

            return response()->json(['status' => 'ok']);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan.'
            ]);
        }
    }


    public function handleFormDeklarasiDinas($chatId, $worker)
    {
        // Mengambil data formtemplate dengan id = 1
        $fsuratdinas = FormTemplate::find(2);
    
        // Mengecek apakah formTemplate ditemukan
        if ($fsuratdinas) {
            // Menyiapkan pesan untuk mengirim ke Telegram
            $message = "Berikut adalah Form Deklarasi Perjalanan Dinas:\n\n";
            $message .= "Nama Form: " . $fsuratdinas->nama_file . "\n";
            $message .= "File: " . $fsuratdinas->form_file . "\n";
            $message .= "Keterangan: " . $fsuratdinas->keterangan . "\n\n";
    
            // Mengirimkan pesan ke Telegram
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message
            ]);
        } else {
            // Jika formTemplate tidak ditemukan
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Form template dengan ID 2 tidak ditemukan."
            ]);
        }
    }

    public function handleFormCutiBesar($chatId, $worker)
    {
        // Mengambil data formtemplate dengan id = 1
        $fcutibesar = FormTemplate::find(3);
    
        // Mengecek apakah formTemplate ditemukan
        if ($fcutibesar) {
            // Menyiapkan pesan untuk mengirim ke Telegram
            $message = "Berikut adalah Form Pengajuan Cuti Besar:\n\n";
            $message .= "Nama Form: " . $fcutibesar->nama_file . "\n";
            $message .= "File: " . $fcutibesar->form_file . "\n";
            $message .= "Keterangan: " . $fcutibesar->keterangan . "\n\n";
    
            // Mengirimkan pesan ke Telegram
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message
            ]);
        } else {
            // Jika formTemplate tidak ditemukan
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Form template dengan ID 2 tidak ditemukan."
            ]);
        }
    }

    public function handleFormIzinLuarTanggungan($chatId, $worker)
    {
        // Mengambil data formtemplate dengan id = 1
        $fizinluar = FormTemplate::find(4);
    
        // Mengecek apakah formTemplate ditemukan
        if ($fizinluar) {
            // Menyiapkan pesan untuk mengirim ke Telegram
            $message = "Berikut adalah Form Pengajuan Izin Diluar Tanggungan Perusahaan:\n\n";
            $message .= "Nama Form: " . $fizinluar->nama_file . "\n";
            $message .= "File: " . $fizinluar->form_file . "\n";
            $message .= "Keterangan: " . $fizinluar->keterangan . "\n\n";
    
            // Mengirimkan pesan ke Telegram
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message
            ]);
        } else {
            // Jika formTemplate tidak ditemukan
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Form template dengan ID 2 tidak ditemukan."
            ]);
        }
    }

    public function handleformUbahRekKaryawan($chatId, $worker)
    {
        // Mengambil data formtemplate dengan id = 1
        $fubahrek = FormTemplate::find(5);
    
        // Mengecek apakah formTemplate ditemukan
        if ($fubahrek) {
            // Menyiapkan pesan untuk mengirim ke Telegram
            $message = "Berikut adalah Form Perubahan Rek. Karyawan:\n\n";
            $message .= "Nama Form: " . $fubahrek->nama_file . "\n";
            $message .= "File: " . $fubahrek->form_file . "\n";
            $message .= "Keterangan: " . $fubahrek->keterangan . "\n\n";
    
            // Mengirimkan pesan ke Telegram
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message
            ]);
        } else {
            // Jika formTemplate tidak ditemukan
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Form template dengan ID 2 tidak ditemukan."
            ]);
        }
    }

    public function handleformKonsultasiMedis($chatId, $worker)
    {
        // Mengambil data formtemplate dengan id = 1
        $fkonsulmedis = FormTemplate::find(6);
    
        // Mengecek apakah formTemplate ditemukan
        if ($fkonsulmedis) {
            // Menyiapkan pesan untuk mengirim ke Telegram
            $message = "Berikut adalah Form Konsultas Medis:\n\n";
            $message .= "Nama Form: " . $fkonsulmedis->nama_file . "\n";
            $message .= "File: " . $fkonsulmedis->form_file . "\n";
            $message .= "Keterangan: " . $fkonsulmedis->keterangan . "\n\n";
    
            // Mengirimkan pesan ke Telegram
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message
            ]);
        } else {
            // Jika formTemplate tidak ditemukan
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Form template dengan ID 2 tidak ditemukan."
            ]);
        }
    }

    public function handleRequestFormLain($chatId)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    
        // Minta keterangan dari karyawan
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Silakan masukkan keterangan untuk permintaan Form.",
        ]);
    }
    
   
   public function handleRequestSuratLain($chatId)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    
        // Minta keterangan dari karyawan
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Silakan masukkan keterangan untuk permintaan Surat lainnya.",
        ]);
    }

    public function handleSurveyChoice($chatId)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        
        // Kirim pilihan survey dengan inline keyboard
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Pilih salah satu opsi survey (1-5):",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => '1', 'callback_data' => 'survey_1']],
                    [['text' => '2', 'callback_data' => 'survey_2']],
                    [['text' => '3', 'callback_data' => 'survey_3']],
                    [['text' => '4', 'callback_data' => 'survey_4']],
                    [['text' => '5', 'callback_data' => 'survey_5']],
                ]
            ])
        ]);
    }

    public function handleSurveyResponse($chatId, $callbackData)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    
        // Menentukan nilai survey berdasarkan callbackData
        $surveyOption = (int) substr($callbackData, 7);  // Mengambil angka dari callback (survey_1 -> 1)
    
        // Ambil user berdasarkan chat_id
        $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();
        if (!$telegramUser) {
            // Jika user tidak ditemukan, beri pesan error
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "User tidak terverifikasi, silakan kirim nomor HP Anda terlebih dahulu.",
            ]);
            return;
        }
    
        // Ambil worker_id dari tabel telegram_users
        $worker_id = $telegramUser->worker_id;
        if (!$worker_id) {
            // Jika worker_id tidak ditemukan
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Tidak ada data pekerja terkait dengan akun Anda.",
            ]);
            return;
        }
    
        // Simpan pilihan survey ke tabel surveys
        Survey::create([
            'worker_id' => $worker_id,  // Menyimpan worker_id ke dalam survey
            'survey_option' => $surveyOption, // Menyimpan opsi survey yang dipilih
        ]);
    
        // Kirimkan konfirmasi ke pengguna
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Terima kasih telah mengisi survey! Pilihan Anda: $surveyOption."
        ]);
    
        // Kembali ke menu utama setelah survey
        $this->showMainMenu($chatId);
    }
    


/*     public function listenForKeteranganForm($chatId)
{
    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

    // Tunggu pesan dari user
    $update = $telegram->getWebhookUpdate();
    Log::info('Webhook update diterima: ' . json_encode($update));

    if ($update->has('message')) {
        $message = $update->getMessage();
        $keterangan = $message->getText(); // Keterangan dari user

        Log::info('Pesan keterangan diterima: ' . $keterangan);

        // Ambil nomor HP karyawan berdasarkan chat_id
        $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();
        if ($telegramUser) {
            // Ambil worker_id berdasarkan nomor HP Telegram
            $worker = $telegramUser->worker()->first();
            if ($worker) {
                // Simpan permintaan form ke database
                $requestForm = new Formlain();
                $requestForm->worker_id = $worker->id;
                $requestForm->tgl_mintaform = now(); // Tanggal saat permintaan
                $requestForm->keterangan = $keterangan; // Keterangan yang diinput
                $requestForm->save();

                Log::info('Permintaan form berhasil disimpan untuk worker_id: ' . $worker->id);

                // Kirim konfirmasi ke karyawan
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Permintaan form Anda telah diterima. Terima kasih.",
                ]);
            } else {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Karyawan tidak ditemukan, pastikan nomor HP Anda terverifikasi.",
                ]);
            }
        } else {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Data Anda belum terverifikasi. Silakan kirim nomor HP terlebih dahulu.",
            ]);
        }
    }
} */
public function handleWebhook(Request $request)
{
    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    $update = $telegram->getWebhookUpdate();

    // Cek apakah ada callback query
    if ($update->has('callback_query')) {
        $callbackQuery = $update->getCallbackQuery();
        $chatId = $callbackQuery->getFrom()->getId();
        $callbackData = $callbackQuery->getData();

        Log::info('CallbackQuery diterima dari chat_id: ' . $chatId . ' dengan data: ' . $callbackData);

        // Ambil user dan pekerja terkait berdasarkan chat_id
        $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();
        if ($telegramUser) {
            $worker = $telegramUser->worker()->first();
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

    // Cek apakah ada pesan biasa (pesan dari pengguna)
    elseif ($update->has('message')) {
        $message = $update->getMessage();
        $chatId = $message->getChat()->getId();
        $text = $message->getText();

        Log::info('Pesan diterima dari chat_id: ' . $chatId . ' dengan pesan: ' . $text);  // Log pesan untuk debugging

        // Jika pengguna mengetik /start
        if ($text == '/start') {
            // Kirim pesan untuk menampilkan menu utama
            $this->showMainMenu($chatId);
        } else {
            // Periksa jika pengguna memilih "Surat Lain"
            if ($text == 'Surat Lain') {
                // Kirim pesan untuk meminta keterangan
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Silakan masukkan keterangan untuk permintaan Surat Lain.",
                ]);
            } else {
                // Jika keterangan diterima, simpan langsung ke database
                if (!empty(trim($text))) {
                    $this->saveSuratLainRequest($chatId, $text); // Menyimpan ke database
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Permintaan Surat Anda telah diterima. Terima kasih.",
                    ]);
                    // Kembali ke menu utama setelah data disimpan
                    $this->showMainMenu($chatId);
                } else {
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Keterangan tidak valid. Silakan kirim keterangan yang sesuai.",
                    ]);
                }
            }
        }
    }

    return response()->json(['status' => 'ok']);
}


public function saveFormLainRequest($chatId, $keterangan)
{
    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

    // Ambil pekerja berdasarkan chat_id
    $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();
    if ($telegramUser) {
        $worker = $telegramUser->worker()->first();

        try {
            // Simpan permintaan form ke database
            $requestForm = new Formlain();
            $requestForm->worker_id = $worker->id;
            $requestForm->tgl_mintaform = now(); // Tanggal saat permintaan
            $requestForm->keterangan = $keterangan; // Keterangan yang diinput
            $requestForm->save();

            Log::info('Permintaan form berhasil disimpan untuk worker_id: ' . $worker->id);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan permintaan form: ' . $e->getMessage());
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.",
            ]);
        }
    }
}

public function saveSuratLainRequest($chatId, $keterangan)
{
    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

    // Ambil pekerja berdasarkan chat_id
    $telegramUser = TelegramUser::where('telegram_chat_id', $chatId)->first();
    if ($telegramUser) {
        $worker = $telegramUser->worker()->first();

        try {
            // Simpan permintaan form ke database
            $requestSurat = new Suratlain();
            $requestSurat->worker_id = $worker->id;
            $requestSurat->tgl_mintasurat = now(); // Tanggal saat permintaan
            $requestSurat->keterangan = $keterangan; // Keterangan yang diinput
            $requestSurat->save();

            Log::info('Permintaan Surat berhasil disimpan untuk worker_id: ' . $worker->id);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan permintaan Surat: ' . $e->getMessage());
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.",
            ]);
        }
    }
}

public function showMainMenu($chatId)
{
    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

    $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => "Halo, pilih menu berikut:",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'Surat Kerja', 'callback_data' => 'surat_kerja']],
                [['text' => 'BPJS', 'callback_data' => 'bpjs']],
                [['text' => 'Etiket', 'callback_data' => 'etiket']],
                [['text' => 'Gaji', 'callback_data' => 'gaji']],
                [['text' => 'Overtime', 'callback_data' => 'overtime']],
                [['text' => 'Rapel USL', 'callback_data' => 'rapel_usl']],
                [['text' => 'Cuti', 'callback_data' => 'cutitahunan']],
                [['text' => 'A. Permintaan Surat', 'callback_data' => 'permintaan_surat']],
                [['text' => 'B. Permintaan Form', 'callback_data' => 'permintaan_form']],
                [['text' => 'Survey', 'callback_data' => 'survey']],
                
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ])
    ]);
}

    
    public function showPermintaanSurat($chatId)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Pilih jenis surat yang Anda butuhkan:",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'Surat Keterangan Aktif Bekerja', 'callback_data' => 'surataktif']],
                    [['text' => 'Surat Keputusan Tetap/Promosi', 'callback_data' => 'suratpromosi']],
                    [['text' => 'Surat Penugasan Dinas', 'callback_data' => 'surat_tugas']],
                    [['text' => 'Daftar Surat Lain', 'callback_data' => 'listsuratlain']],
                    [['text' => 'Surat Lain (request)', 'callback_data' => 'requestsurat_lain']], //di panggil di sini 
                    
                ]
            ])
        ]);
    }

    public function showPermintaanForm($chatId)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => "Pilih form yang Anda butuhkan:",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'Form Pengajuan Surat Tugas', 'callback_data' => 'formsurattugas']],
                    [['text' => 'Form Deklarasi Perjalan Dinas', 'callback_data' => 'formdeklarasidinas']],
                    [['text' => 'Form Pengajuan Cuti Besar', 'callback_data' => 'formcutibesar']],
                    [['text' => 'From Pengajuan Izin Diluar Tanggungan Perusahaan', 'callback_data' => 'formizinluartanggungan']],
                    [['text' => 'Form Perubahan Rek. Karyawan', 'callback_data' => 'formubahrek']],
                    [['text' => 'Form Konsultas Medis', 'callback_data' => 'formkonsulmedis']],
                    [['text' => 'Form Lain', 'callback_data' => 'requestform_lain']],
                ]
            ])
        ]);
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