<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BranchOffice;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Traits\ApiResponser;
class BranchOfficeController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(BranchOffice::where("status",true)->get());
        

        
    }
    public function indexPaginate()
    {
        
        try {
            return $this->successResponse(BranchOffice::where('status',"=",true)->paginate(10));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
            // return $this->errorResponse("error", 500);
        }

        
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
            $branchOffice = BranchOffice::create($request->all());
            DB::commit();
            return $this->successResponse($branchOffice, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchOffice  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function show(BranchOffice $branchOffice)
    {
        return response(
            [
                'branchOffice' => $branchOffice, 
            ], 200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchOffice  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchOffice $branchOffice)
    {
        DB::beginTransaction();
        try {
            $branchOffice->update( $request->all() );
            DB::commit();
            return $this->successResponse($branchOffice, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchOffice  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchOffice $branchOffice)
    {
        DB::beginTransaction();
        try {
            $branchOffice->update( ["status"=>false] );
            DB::commit();
            return $this->successResponse($branchOffice, 200); 
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }
}
