<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialty;
use App\Models\DoctorWithSpecialty;
use Validator;
use DB;
use App\Traits\ApiResponser;

class PassportController extends Controller
{
    use ApiResponser;
    // public function __construct()
    // {
    //       $this->middleware('auth');
    // }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'success' => false], 422);
        }

        try{
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect']
                ]);
            }

            $token = $user->createToken('users')->accessToken;
            return $this->successResponse(['token' => $token]);

        }catch(\Exception $e){
            // return $e;
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required',
            ]);
            if($validator->fails()){
                return response(['message' => 'Validation errors', 'errors' =>  $validator->errors()], 422);
            }
            $user = User::create($request->all())->assignRole('admin');
            $data['user'] = $user;
            DB::commit();
            
            return $this->successResponse($data, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    public function storeDoctor(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'branch_office_id' => 'required',
                'name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required',
                'phone' => 'required',
            ]);
            if($validator->fails()){
                return response(['message' => 'Validation errors', 'errors' =>  $validator->errors()], 422);
            }
            $user = User::create($request->all())->assignRole('doctor');
            if($request->has('specialties')){
                foreach ($request->specialties as $specialty_id) {
                    DoctorWithSpecialty::create(["user_id"=>$user->id,"specialty_id"=>$specialty_id]);
                }
            }
            $data['user'] = $user;
            $data['user']['specialties'] = Specialty::find($request->specialties);
            DB::commit();
            return $this->successResponse($data, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    public function storePatient(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'branch_office_id' => 'required',
                'name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required',
                'phone' => 'required',
            ]);
            if($validator->fails()){
                return response(['message' => 'Validation errors', 'errors' =>  $validator->errors()], 422);
            }
            $user = User::create($request->all())->assignRole('patient');
            // $data['token'] =  $user->createToken('users')->accessToken;
            $data['user'] = $user;
            DB::commit();
            return $this->successResponse($data, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
            // return response($th->getMessage(), 400);
        }
    }

    public function authUserInfo(Request $request)
    {
        try{
            $user = Auth::user();
            if($user != null){
                return response()->json([ 'user' => $user ],200);
            }else{
                return response()->json("Usuario no identificado.", 404);
            }
        }catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 400);
            // return response()->json($th->getMessage(), 400);
        }
    }

    public function test(Request $request)
    {
        return "a";
    }
}
