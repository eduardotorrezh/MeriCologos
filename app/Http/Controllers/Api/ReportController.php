<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Models\DatesInfo;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Traits\ApiResponser;
use App\Traits\DateTrait;
use Carbon\Carbon;
class ReportController extends Controller
{
    use ApiResponser;
    use DateTrait;
  


    function reportsDates($id){
        Carbon::setLocale('es');
        $now = Carbon::now();
        $results = Date::where('doctor_id','=',$id)->orderBy('date','ASC')->orderBy('shift_id','ASC')->with(['shift','patient','doctor','dates_info'])->get();
        $dates = $this->getDates($results);
        return view('reports.datesReport',["dates"=>$dates,"now"=>$now]);
    }


    function gains(){

    }

}
