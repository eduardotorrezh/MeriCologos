<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;
use DateTime;

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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            foreach (User::role('patient')->get() as $patient) {
                $date = Date::where("patient_id",$patient->id)->orderBy('id','DESC')->first();
                // $ultimaReunion ='2021-01-01 20:22:05';
                $ultimaReunion = $date->created_at;
                $ultimaReunion  = new DateTime($ultimaReunion);
                $hoy = new DateTime(Date("Y-m-d"));
                $days = $ultimaReunion->diff($hoy);
                $days = $days->format('%d%');
                if ($days > 10){
                    $patient->update(["active"=>false]);
                }
            }
        })->daily();
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
