<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Validator;
use DB;

class ConfigurationController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(Configuration::findOrFail(1));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'wsp_message_doctor' => 'required',
                'wsp_message_client' => 'required',
                'min_time_cancel_date' => 'required',
                'max_time_create_date' => 'required',
            ]);
            if($validator->fails()){
                return response(
                    [
                        'message' => 'Validation errors', 
                        'errors' =>  $validator->errors()
                    ], 422
                );
            }
            $configuration = Configuration::findOrFail(1);
            $configuration->update($request->all());
            DB::commit();
            return $this->successResponse($configuration, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            // return response($th->getMessage(), 400);
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

}
