<?php

namespace App\Http\Controllers\Move;

use App\Http\Controllers\Controller;
use App\Models\Move;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoveBrowseController extends Controller
{
    use Datatables;

    public function Anything(Request $request){
        $this->datatables($request);
        $searchValue = $this->searchValue;
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay();
        $date_end = Carbon::parse($request->get('date_end'))->endOfDay();

        $response['count'] = Move::select('count(*) as allcount')
            ->join("users", "move.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id")
            ->leftjoin("population", "population.user_id", "users.id")
            ->whereBetween('move.created_at', [$date_from, $date_end]);

        $response['totalRecordswithFilter'] = Move::join("users", "move.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id")
            ->leftjoin("population", "population.user_id", "users.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("move.date_of_move", "like", "%". $searchValue . "%")
                   
                    //User
                    ->orWhere("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%")
                    
                    // Family
                    ->orWhere("family.number_family", "like", "%". $searchValue . "%")
                    ->orWhere("family.head", "like", "%". $searchValue . "%")

                     // Population
                     ->orWhere("population.nik", "like", "%". $searchValue . "%");
            })->whereBetween('move.created_at', [$date_from, $date_end]);
                            
        $response['records'] = Move::select(
            'move.id as id',
            'move.date_of_move as date_of_move',
            'move.reason as reason',

            // user
            'users.name as name',
            'users.gender as gender',
            'users.birthdate as birthdate',
            
            // Family
            'family.number_family as number_family',
            'family.head as head',

            // Population
            'population.nik as nik',

            'move.created_at as created_at',
            'move.updated_at as updated_at'
            )->join("users", "move.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id")
            ->leftjoin("population", "population.user_id", "users.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("move.date_of_move", "like", "%". $searchValue . "%")
                
                    //User
                    ->orWhere("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%")

                    // Family
                    ->orWhere("family.number_family", "like", "%". $searchValue . "%")
                    ->orWhere("family.head", "like", "%". $searchValue . "%")

                    // Population
                    ->orWhere("population.nik", "like", "%". $searchValue . "%");
            })->whereBetween('move.created_at', [$date_from, $date_end]);  


        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get();
        $data_arr = array();

        foreach($response['records'] as $record){
            $id = $record->id;
            $nik = $record->nik;
            $name = $record->name;
            $date_of_move = $record->date_of_move;
            $reason = $record->reason;
            $action = "test";
            
            $data_arr[] = array(
                "id" => $id,
                "nik" => $nik,
                "name" => $name,
                "date_of_move" => $date_of_move,
                "reason" => $reason,
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
        exit; 
    }
}
