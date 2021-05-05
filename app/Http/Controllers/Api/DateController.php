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

            $request["dates_infos_id"] = $DI->id;
            for ($i=$init_date; $i < $end_date; $i = $i + 0.5) { 
                $request["shift"] = $i *2;
                $date = Date::create($request->all());
            }
            DB::commit();
            return $this->successResponse($date, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return response($th->getMessage(), 400);
        }
    }
}
