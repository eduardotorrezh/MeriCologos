<?php

namespace App\Console\Commands;
use DB;
use App\Models\Date;
use Illuminate\Console\Command;
use Carbon\Carbon;
class DatesNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dates:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa las proximas citas y envia notificacion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();


        $init_date = getDate(strtotime($now))["hours"];
        $init_date = $init_date * 2;
        if(getDate(strtotime($now))["minutes"] !=0 ){
            $init_date = $init_date + 1;
        }

        $dates = Date::orderBy("dates_infos_id")->orderBy("shift_id")->get();

        $lastID= 0;
        foreach ($dates as $key => $value) {
            if($lastID != $value->dates_infos_id){
                if($now->toDateString() == Carbon::parse($value->date)->toDateString()  ) {
                    if($init_date - $value->shift_id == 8){
                        $this->sendWhatsAppMessage("Faltan 4h para su cita","whatsapp:+521".$value->patient->phone);
                    }
                }
                $lastID = $value->dates_infos_id;
            }

        }
    }
}
