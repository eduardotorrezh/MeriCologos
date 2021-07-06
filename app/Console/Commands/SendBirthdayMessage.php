<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
use Twilio\Rest\Client;

class SendBirthdayMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command send whatsapp message in user´s birthday.';

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
        $message = "El consultorio médico te desea un excelente día. Feliz cumpleaños. ";
        foreach (User::whereMonth('birthday', '=', Carbon::now()->format('m'))->whereDay('birthday', '=', Carbon::now()->format('d'))->whereNotNull('status_patient')->get() as $user) {
            $this->sendWhatsAppMessage($message,"whatsapp:+521".$user->phone);
        }
    }

    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }

}
