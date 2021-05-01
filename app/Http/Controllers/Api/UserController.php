<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use DB;

class UserController extends Controller
{
    public function updateUser(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'branch_office_id' => 'required',
                'name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
            ]);
            if($validator->fails()){
                return response(['message' => 'Validation errors', 'errors' =>  $validator->errors()], 422);
            }
            $user->update($request->all());
            DB::commit();
            return response($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollback();
            return response($th->getMessage(), 400);
        }
    }

    public function show(User $user)
    {
        try {
            return response($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
        }
    }

    public function admins()
    {
        try {
            return response($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
        }
    }
    public function patients()
    {
        try {
            $user = User::role('patient')->get();
            return response($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
        }
    }
    public function doctors()
    {
        try {
            $user = User::role('doctor')->get();
            return response($user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
        }
    }
}
