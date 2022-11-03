<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PositionBrowseController extends Controller
{
    use Datatables;

    public function Anything(Request $request){
        $this->datatables($request);
        $searchValue = $this->searchValue;
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay();
        $date_end = Carbon::parse($request->get('date_end'))->endOfDay();

        $response['count'] = Position::select('count(*) as allcount')->whereBetween('positions.created_at', [$date_from, $date_end]);

        $response['totalRecordswithFilter'] = Position::where(function ($query) use ($searchValue) {
                $query->where("positions.name", "like", "%". $searchValue . "%");
            })->whereBetween('positions.created_at', [$date_from, $date_end]);
                            
        $response['records'] = Position::where(function ($query) use ($searchValue) {
            $query->where("positions.name", "like", "%". $searchValue . "%");
            })->whereBetween('positions.created_at', [$date_from, $date_end]);  


        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get()->toArray();

        dd($response);
    }
}
