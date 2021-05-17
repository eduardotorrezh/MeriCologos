<?php

namespace App\Http\Controllers\Api;

use App\Models\Specialty;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Validator;
use DB;

class SpecialtyController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(Specialty::where("status",true)->get());
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
            ]);
            if($validator->fails()){
                return response(
                    [
                        'message' => 'Validation errors', 
                        'errors' =>  $validator->errors()
                    ], 422
                );
            }
            $specialty = Specialty::create($request->all());
            DB::commit();
            return $this->successResponse($specialty, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            // return response($th->getMessage(), 400);
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function show(Specialty $specialty)
    {
        return response(
            [
                'specialties' => $specialty, 
            ], 200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specialty $specialty)
    {
        DB::beginTransaction();
        try {
            $specialty->update( $request->all() );
            DB::commit();
            return $this->successResponse($specialty, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialty $specialty)
    {
        DB::beginTransaction();
        try {
            $specialty->update( ["status"=>false] );
            DB::commit();
            return $this->successResponse($specialty, 200); 
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }
}
