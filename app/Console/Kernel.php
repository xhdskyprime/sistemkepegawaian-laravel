<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\SchedulerSetting;
use App\Console\Commands\SendSIPNotifications;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SendSIPNotifications::class,
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $setting = SchedulerSetting::first();

        // Default: Minggu jam 9:00 jika belum diset
        $day = $setting?->day_of_week ?? 'sun';
        $hour = $setting?->hour ?? 9;
        $minute = $setting?->minute ?? 0;

        $cron = "{$minute} {$hour} * * " . $this->convertDay($day);

        $schedule->command('send:sip-notifications')->cron($cron);
    }

    // Tambahkan helper jika perlu
    protected function convertDay($day)
    {
        // Laravel menerima: 0=Sun, 1=Mon,...
        return match (strtolower($day)) {
            'sun' => 0,
            'mon' => 1,
            'tue' => 2,
            'wed' => 3,
            'thu' => 4,
            'fri' => 5,
            'sat' => 6,
            default => '*'
        };
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
