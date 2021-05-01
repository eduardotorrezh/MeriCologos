<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
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

            $user = User::create($request->all());
            $data['token'] =  $user->createToken('users')->accessToken;
            $data['user'] = $user;

            DB::commit();
            return $this->successResponse($data, Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            DB::rollback();
            return response($th->getMessage(), 400);
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
            return response()->json($th->getMessage(), 400);
        }
    }

    public function test(Request $request)
    {
        return "a";
    }
}
