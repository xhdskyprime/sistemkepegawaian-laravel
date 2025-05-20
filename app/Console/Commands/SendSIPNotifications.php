<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Log;

class SendSIPNotifications extends Command
{
    protected $signature = 'send:sip-notifications';
    protected $description = 'Kirim notifikasi SIP via email & Telegram';

    public function handle()
    {
        Log::info('🟢 Running scheduled SIP notification...');

        // Panggil metode controller yang sudah kamu buat
        app(EmployeeController::class)->sendEmailMassal();
        app(EmployeeController::class)->sendRekapEmail();
        app(EmployeeController::class)->sendRekapTelegram();

        Log::info('✅ Finished scheduled SIP notification');
    }
}
