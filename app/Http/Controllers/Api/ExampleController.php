<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ExampleController extends Controller
{
    public function index()
    {
        return User::whereMonth('birthday', '=', Carbon::now()->format('m'))->whereDay('birthday', '=', Carbon::now()->format('d'))->get();
    }
}
