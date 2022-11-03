<?php

namespace App\Http\Controllers\Family;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FamilyBrowseController extends Controller
{
    use Datatables;

    public function Anything(Request $request){
        $this->datatables($request);
        $searchValue = $this->searchValue;
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay();
        $date_end = Carbon::parse($request->get('date_end'))->endOfDay();

        $response['count'] = Family::select('count(*) as allcount')->whereBetween('family.created_at', [$date_from, $date_end]);

        $response['totalRecordswithFilter'] = Family::where(function ($query) use ($searchValue) {
                $query->where("family.number_family", "like", "%". $searchValue . "%")
                    ->orWhere("family.number_family", "like", "%". $searchValue . "%")
                    ->orWhere("family.head", "like", "%". $searchValue . "%")
                    ->orWhere("family.village", "like", "%". $searchValue . "%")
                    ->orWhere("family.neighbourhood", "like", "%". $searchValue . "%")
                    ->orWhere("family.hamlet", "like", "%". $searchValue . "%")
                    ->orWhere("family.sub_districts", "like", "%". $searchValue . "%")
                    ->orWhere("family.districts", "like", "%". $searchValue . "%")
                    ->orWhere("family.province", "like", "%". $searchValue . "%");
            })->whereBetween('family.created_at', [$date_from, $date_end]);
                            
        $response['records'] = Family::where(function ($query) use ($searchValue) {
            $query->where("family.number_family", "like", "%". $searchValue . "%")
                ->orWhere("family.number_family", "like", "%". $searchValue . "%")
                ->orWhere("family.head", "like", "%". $searchValue . "%")
                ->orWhere("family.village", "like", "%". $searchValue . "%")
                ->orWhere("family.neighbourhood", "like", "%". $searchValue . "%")
                ->orWhere("family.hamlet", "like", "%". $searchValue . "%")
                ->orWhere("family.sub_districts", "like", "%". $searchValue . "%")
                ->orWhere("family.districts", "like", "%". $searchValue . "%")
                ->orWhere("family.province", "like", "%". $searchValue . "%");
            })->whereBetween('family.created_at', [$date_from, $date_end]);  

        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get()->toArray();

        dd($response);
    }
}
