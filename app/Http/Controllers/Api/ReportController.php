<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\PatientExport;
use App\Exports\PatientBranchOfficeExport;
use Excel;

class ReportController extends Controller
{
    public function patientReportXLS(){
        return Excel::download(new PatientExport(), 'reporte_por_pacientes.xlsx');
    }

    public function patientBrachOfficeReportXLS(Request $request){
        return Excel::download(new PatientBranchOfficeExport($request), 'reporte_por_sucursal_y_pacientes.xlsx');
    }
}
