<?php

namespace App\Console;

use App\Drivers\KorespondentDriver;
use App\Helpers\DbHelper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $driver = new KorespondentDriver();
            $helper = new DbHelper();
            $htmlArray = $driver->getBanksCoursesHtml();
            $result = $helper->seveFromHrmlArr($htmlArray);
        })->twiceDaily(8, 16);//dailyAt('12:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
