<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\User;
use DateTime;
use DateTimeZone;
class PatientBranchOfficeExport implements FromView{

    private $id;
    public function __construct(Request $request){
        $this->id = $request->branch_office_id;
    }

    public function view(): View{
        $branch_office_id = $this->id;
        $d = new DateTime('NOW',new DateTimeZone('America/Mexico_City'));
        $date =  $d->format('Y-m-d H:i:s');
        $users = User::Where("status",true)->where("branch_office_id",$branch_office_id)->whereNotNull('status_patient')->get();
        return view('reports.report2',["users"=>$users,"date"=>$date]);
    }
}