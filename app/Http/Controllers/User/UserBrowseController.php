<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserBrowseController extends Controller
{
    use Datatables;

    public function Anything(Request $request){
        $this->datatables($request);
        $searchValue = $this->searchValue;
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay();
        $date_end = Carbon::parse($request->get('date_end'))->endOfDay();

        $response['count'] = User::select('count(*) as allcount')
            ->join("population", "population.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id");
            

        $response['totalRecordswithFilter'] = User::join("population", "population.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%")
                    
                    // Population
                    ->orWhere("population.nik", "like", "%". $searchValue . "%")
                    ->orWhere("population.place_of_birth", "like", "%". $searchValue . "%")
                    ->orWhere("population.gender", "like", "%". $searchValue . "%")
                    ->orWhere("population.village", "like", "%". $searchValue . "%")
                    ->orWhere("population.neighbourhood", "like", "%". $searchValue . "%")
                    ->orWhere("population.hamlet", "like", "%". $searchValue . "%")
                    ->orWhere("population.religion", "like", "%". $searchValue . "%")
                    ->orWhere("population.married", "like", "%". $searchValue . "%")
                    ->orWhere("population.occupation", "like", "%". $searchValue . "%")
                    ->orWhere("population.status", "like", "%". $searchValue . "%")
                    
                    // family
                    ->orWhere("family.number_family", "like", "%". $searchValue . "%");
            });
                            
        $response['records'] = User::orderBy($this->columnName,$this->columnSortOrder)->select(
            // user
            'users.id as id',
            'users.name as name',
            'users.gender as gender',
            'users.birthdate as birthdate',
            'users.created_at as created_at',
            'users.updated_at as updated_at',

            // Population
            "population.nik as nik",
            "population.place_of_birth as place_of_birth",
            "population.gender as gender",
            "population.village as village",
            "population.neighbourhood as neighbourhood",
            "population.hamlet as hamlet",
            "population.religion as religion",
            "population.married as married",
            "population.occupation as occupation",
            "population.status as status",

            // Population
            "family.number_family as number_family",
            )->join("population", "population.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%")
                    
                    // Population
                    ->orWhere("population.nik", "like", "%". $searchValue . "%")
                    ->orWhere("population.place_of_birth", "like", "%". $searchValue . "%")
                    ->orWhere("population.gender", "like", "%". $searchValue . "%")
                    ->orWhere("population.village", "like", "%". $searchValue . "%")
                    ->orWhere("population.neighbourhood", "like", "%". $searchValue . "%")
                    ->orWhere("population.hamlet", "like", "%". $searchValue . "%")
                    ->orWhere("population.religion", "like", "%". $searchValue . "%")
                    ->orWhere("population.married", "like", "%". $searchValue . "%")
                    ->orWhere("population.occupation", "like", "%". $searchValue . "%")
                    ->orWhere("population.status", "like", "%". $searchValue . "%")

                     // family
                     ->orWhere("family.number_family", "like", "%". $searchValue . "%");
            });  

        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get();
        $data_arr = array();

        foreach($response['records'] as $record){
            $id = $record->id;
            $name = $record->name;
            $nik = $record->nik;
            $village = $record->village;
            $religion = $record->religion;
            $occupation = $record->occupation;
            $number_family = $record->number_family;
            $status = $record->status;
            
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "nik" => $nik,
                "village" => $village,
                "religion" => $religion,
                "occupation" => $occupation,
                "number_family" => $number_family,
                "status" => $status
            );
        }

        $response = array(
            "draw" => intval($this->draw),
            "iTotalRecords" => $response['count'],
            "iTotalDisplayRecords" => $response['totalRecordswithFilter'],
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit; 
    }
}
