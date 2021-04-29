<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BranchOffice;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Validator;
use DB;

class BranchOfficeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return response(
            [
                'branchOffices' => BranchOffice::where("status",true)->get(), 
            ], 200
        );
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
            return response($branchOffice, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return response($th->getMessage(), 400);
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
            return response($branchOffice, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response($th->getMessage(), 400);
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
            return response($branchOffice, 200); 
        } catch (\Throwable $th) {
            DB::rollback();
            return response($th->getMessage(), 400);
        }
    }
}
