<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function Anything(Request $request, $Uuid)
    {   
        if ($Uuid == 'penduduk') { 
            $Url = (new PendudukReportController)->Anything($request);
        }
        if ($Uuid == 'born') { 
            $Url = (new BornReportController)->Anything($request);
        }
        if ($Uuid == 'dead') { 
            $Url = (new DeadReportController)->Anything($request);
        }
        if ($Uuid == 'comer') { 
            $Url = (new ComerReportController)->Anything($request);
        }
        if ($Uuid == 'move') { 
            $Url = (new MoveReportController)->Anything($request);
        }
        if ($Uuid == 'family') { 
            $Url = (new FamilyReportController)->Anything($request);
        }
        return response()->json($Url, 200);
    }
}
