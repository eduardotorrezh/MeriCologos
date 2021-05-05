<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shifts;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Traits\ApiResponser;

class ShiftController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(Shifts::all());
        
    }

}
