<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\User;
use DateTime;
use DateTimeZone;
class PatientExport implements FromView{

    public function __construct(){

    }

    public function view(): View{
        $d = new DateTime('NOW',new DateTimeZone('America/Mexico_City'));
        $date =  $d->format('Y-m-d H:i:s');
        $users = User::Where("status",true)->whereNotNull('status_patient')->get();
        return view('reports.report',["users"=>$users,"date"=>$date]);
    }
}