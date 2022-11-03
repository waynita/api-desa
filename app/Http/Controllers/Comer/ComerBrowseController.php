<?php

namespace App\Http\Controllers\Comer;

use App\Http\Controllers\Controller;
use App\Models\Comer;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComerBrowseController extends Controller
{
    use Datatables;

    public function Anything(Request $request){
        $this->datatables($request);
        $searchValue = $this->searchValue;
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay();
        $date_end = Carbon::parse($request->get('date_end'))->endOfDay();

        $response['count'] = Comer::select('count(*) as allcount')
            ->join("users", "comer.whistleblower_id", "users.id")->whereBetween('comer.created_at', [$date_from, $date_end]);

        $response['totalRecordswithFilter'] = Comer::join("users", "comer.whistleblower_id", "users.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("comer.nik", "like", "%". $searchValue . "%")
                    ->orWhere("comer.name", "like", "%". $searchValue . "%")
                    ->orWhere("comer.gender", "like", "%". $searchValue . "%")
                   
                    //User
                    ->orWhere("users.first_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.last_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%");
            })->whereBetween('comer.created_at', [$date_from, $date_end]);
                            
        $response['records'] = Comer::select(
            'comer.id as id',
            'comer.nik as nik',
            'comer.name as name',
            'comer.gender as gender',
            'comer.date_of_come as date_of_come',
            'comer.whistleblower_id as whistleblower_id',
            // user
            'users.first_name as first_name',
            'users.last_name as last_name',
            'users.gender as gender',
            'users.birthdate as birthdate',

            'comer.created_at as created_at',
            'comer.updated_at as updated_at'
            )->join("users", "comer.whistleblower_id", "users.id")->where(function ($query) use ($searchValue) {
                $query->where("comer.name", "like", "%". $searchValue . "%")
                    ->orWhere("comer.name", "like", "%". $searchValue . "%")
                    ->orWhere("comer.gender", "like", "%". $searchValue . "%")
                
                    //User
                    ->orWhere("users.first_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.last_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%");
            })->whereBetween('comer.created_at', [$date_from, $date_end]);  

        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get()->toArray();

        dd($response);
    }
}
