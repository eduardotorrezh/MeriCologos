<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Validator;
use DB;

class SaleController extends Controller
{

    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(Sale::with(['datesInfo','sale_info','user_id','user_id.branchOffice'])->get());
    }

}
