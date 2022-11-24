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
            ->join("users", "dead.user_id", "users.id")
            ->leftJoin('population', 'population.user_id', 'users.id');

        $response['totalRecordswithFilter'] = Dead::join("users", "dead.user_id", "users.id")
            ->leftJoin('population', 'population.user_id', 'users.id')
            ->where(function ($query) use ($searchValue) {
                $query->where("dead.cause_of_death", "like", "%". $searchValue . "%")
                    ->orWhere("dead.date_of_death", "like", "%". $searchValue . "%")
                   
                    //User
                    ->orWhere("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%");
            });
                            
        $response['records'] = Dead::orderBy($this->columnName,$this->columnSortOrder)->select(
            'dead.id as id',
            'dead.cause_of_death as cause_of_death',
            'dead.date_of_death as date_of_death',
            
            // user
            'users.name as name',
            'users.gender as gender',
            'users.birthdate as birthdate',

            // Population
            'population.nik as nik',

            'dead.created_at as created_at',
            'dead.updated_at as updated_at'
            )->join("users", "dead.user_id", "users.id")
            ->leftJoin('population', 'population.user_id', 'users.id')
            ->where(function ($query) use ($searchValue) {
                $query->where("dead.cause_of_death", "like", "%". $searchValue . "%")
                    ->orWhere("dead.date_of_death", "like", "%". $searchValue . "%")
                
                    //User
                    ->orWhere("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%");
            });  

        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get();
        $data_arr = array();

        foreach($response['records'] as $record){
            $id = $record->id;
            $nik = $record->nik;
            $name = $record->name;
            $date_of_dead = $record->date_of_death;
            $cause_of_dead = $record->cause_of_death;
            $action = '<a type="button" onClick="deletes('. $id .')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            
            $data_arr[] = array(
                "id" => $id,
                "nik" => $nik,
                "name" => $name,
                "date_of_dead" => $date_of_dead,
                "cause_of_dead" => $cause_of_dead,
                "action" => $action
            );
        }

        $response = array(
            "draw" => intval($this->draw),
            "iTotalRecords" => $response['count'],
            "iTotalDisplayRecords" => $response['totalRecordswithFilter'],
            "aaData" => $data_arr
        );

        echo json_encode($response);
    }
}
