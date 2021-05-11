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

class DateController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(Date::all());
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'init_hour' => 'required',
            'end_hour' => 'required',
        ]);
        if($validator->fails()){
            return response(
                [
                    'message' => 'Validation errors', 
                    'errors' =>  $validator->errors()
                ], 422
            );
        }
        DB::beginTransaction();
        try {



            $init_date = getDate(strtotime($request->init_hour))["hours"];
            $end_date = getDate(strtotime($request->end_hour))["hours"];
            $DI = DatesInfo::create();
            $request["date"] = $request->init_hour;
            $request["dates_infos_id"] = $DI->id;
            for ($i=$init_date; $i < $end_date; $i = $i + 0.5) {
                if(count(Date::where("shift_id",$i * 2)->where("date",date("Y-m-d",strtotime($request->init_hour )))->where("doctor_id",$request->doctor_id)->get() ) != 0 ){
                    DB::rollback();
                    return $this->errorResponse('este turno ya esta ocupado', 400);
                }else{
                    $request["shift_id"] = $i *2;
                    $i *2;
                    $date = Date::create($request->all());
                }
            }
            DB::commit();
            return $this->successResponse($DI, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    public function setAbsence(Request $request, DatesInfo $datesInfo)
    {
        DB::beginTransaction();
        try {
            $datesInfo->update(["assistance"=>false]);
            if($datesInfo->assistance){
                $firstDate = $datesInfo->Dates->first();
                $firstDate->patient->update(["absences"=>$firstDate->patient->absences+1]);
            }
            DB::commit();
            return $this->successResponse($datesInfo, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
        }
    }
}
