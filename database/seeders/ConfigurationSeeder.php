<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            "wsp_message_client"=>"Hola! Es un gusto para nosotros poder atenderte. La información de tu cita es la siguiente: ",
            "wsp_message_doctor"=>"Hola! Se ha generado una cita en tu horario, la información es la siguiente: ",
            "min_time_cancel_date"=>"12", //Hour
            "max_time_create_date"=>"2" //Month
        ]);
    }
}
