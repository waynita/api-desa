<?php

namespace App\Http\Controllers\Dead;

use App\Http\Controllers\Controller;
use App\Models\Dead;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeadBrowseController extends Controller
{
    use Datatables;

    public function Anything(Request $request){
        $this->datatables($request);
        $searchValue = $this->searchValue;
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay();
        $date_end = Carbon::parse($request->get('date_end'))->endOfDay();

        $response['count'] = Dead::select('count(*) as allcount')
            ->join("users", "dead.user_id", "users.id")->whereBetween('dead.created_at', [$date_from, $date_end]);

        $response['totalRecordswithFilter'] = Dead::join("users", "dead.user_id", "users.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("dead.cause_of_death", "like", "%". $searchValue . "%")
                    ->orWhere("dead.date_of_death", "like", "%". $searchValue . "%")
                   
                    //User
                    ->orWhere("users.first_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.last_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%");
            })->whereBetween('dead.created_at', [$date_from, $date_end]);
                            
        $response['records'] = Dead::select(
            'dead.id as id',
            'dead.cause_of_death as cause_of_death',
            'dead.date_of_death as date_of_death',
            
            // user
            'users.first_name as first_name',
            'users.last_name as last_name',
            'users.gender as gender',
            'users.birthdate as birthdate',

            'dead.created_at as created_at',
            'dead.updated_at as updated_at'
            )->join("users", "dead.user_id", "users.id")->where(function ($query) use ($searchValue) {
                $query->where("dead.cause_of_death", "like", "%". $searchValue . "%")
                    ->orWhere("dead.date_of_death", "like", "%". $searchValue . "%")
                
                    //User
                    ->orWhere("users.first_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.last_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%");
            })->whereBetween('dead.created_at', [$date_from, $date_end]);  

        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get()->toArray();

        dd($response);
    }
}
