<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorWithSpecialty;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\User;
use Validator;
use DB;

class UserController extends Controller
{

    use ApiResponser;

    public function updateUser(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'branch_office_id' => 'required',
                'name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);
            if($validator->fails()){
                return response(['message' => 'Validation errors', 'errors' =>  $validator->errors()], 422);
            }
            $user->update($request->all());
            //Si es doctor recibe sus especialidades.
            $role = $user->getRoleNames();
            if($role[0] == "doctor"){
                if($request->has('specialties')){
                    DoctorWithSpecialty::where("user_id",$user->id)->delete();
                    foreach ($request->specialties as $specialty_id) {
                        DoctorWithSpecialty::create(["user_id"=>$user->id,"specialty_id"=>$specialty_id]);
                    }
                }
                DB::commit();
                return User::where("id",$user->id)->with("doctorWithSpecialties.specialty")->first();
            }
            DB::commit();
            return $this->successResponse($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    public function show(User $user)
    {
        try {
            $role = $user->getRoleNames();
            if($role[0] == "doctor"){
                return User::where("id",$user->id)->with("doctorWithSpecialties.specialty")->first();
            }
            return $this->successResponse($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    public function medicalHistory(Request $request)
    {
        try {
            $user = User::role('patient')->with(['dates.dates_info','dates.dates_info','dates.patient','dates.doctor'])->get();
            return $this->successResponse($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    public function medicalHistoryByUser(User $user)
    {
        try {
            $data = User::where('id',$user->id)->with(['dates.dates_info','dates.dates_info','dates.patient','dates.doctor'])->first();

            return $this->successResponse($data, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    public function admins()
    {
        try {
            $user = User::role('admin')->with(['branchOffice'])->paginate(10);
            return $this->successResponse($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }
    public function patients()
    {
        try {
            $user = User::role('patient')->with(['branchOffice'])->paginate(10);
            return $this->successResponse($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }
    public function doctors()
    {
        try {
            $user = User::role('doctor')->with(['branchOffice','doctorWithSpecialties.specialty'])->paginate(10);
            return $this->successResponse($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    public function userDates(User $user)
    {
        try {
            return $this->successResponse($user->dates, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
        }
    }

    public function activepatients(User $user)
    {
        try {
            return $this->successResponse($user->dates, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
        }
    }

}
