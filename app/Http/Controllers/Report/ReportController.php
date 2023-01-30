<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function Anything(Request $request, $Uuid)
    {   
        if ($Uuid == 'penduduk') { 
            $Url = (new PendudukReportController)->Anything($request);
        }

        return response()->json($Url, 200);
    }
}
