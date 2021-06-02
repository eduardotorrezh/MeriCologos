<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use App\Models\ServiceWithSpecialty;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Validator;
use DB;

class ServiceController extends Controller
{

    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(Service::where("status",true)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
            ]);
            if($validator->fails()){
                return response(
                    [
                        'message' => 'Validation errors', 
                        'errors' =>  $validator->errors()
                    ], 422
                );
            }
            $service = Service::create($request->all());

            if($request->has('specialties')){
                foreach ($request->specialties as $specialty_id) {
                    ServiceWithSpecialty::create(["service_id"=>$service->id,"specialty_id"=>$specialty_id]);
                }
            }

            DB::commit();

            return $this->successResponse($service, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            // return response($th->getMessage(), 400);
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return $this->successResponse($service, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
            ]);
            if($validator->fails()){
                return response(
                    [
                        'message' => 'Validation errors', 
                        'errors' =>  $validator->errors()
                    ], 422
                );
            }

            $service->update( $request->all() );

            DB::commit();
            
            return $this->successResponse($service, 200);
        } catch (\Throwable $th) {
            
            DB::rollback();
            
            return $this->errorResponse($th->getMessage(), 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        DB::beginTransaction();
        try {
            $service->update( ["status"=>false] );
            DB::commit();
            return $this->successResponse($service, 200); 
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
        }
    }
}
