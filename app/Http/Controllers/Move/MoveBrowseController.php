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
            ->whereBetween('move.created_at', [$date_from, $date_end]);

        $response['totalRecordswithFilter'] = Move::join("users", "move.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("move.date_of_move", "like", "%". $searchValue . "%")
                   
                    //User
                    ->orWhere("users.first_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.last_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%")
                    
                    // Family
                    ->orWhere("family.number_family", "like", "%". $searchValue . "%")
                    ->orWhere("family.head", "like", "%". $searchValue . "%");
            })->whereBetween('move.created_at', [$date_from, $date_end]);
                            
        $response['records'] = Move::select(
            'move.id as id',
            'move.date_of_move as date_of_move',

            // user
            'users.first_name as first_name',
            'users.last_name as last_name',
            'users.gender as gender',
            'users.birthdate as birthdate',
            
            // Family
            'family.number_family as number_family',
            'family.head as head',

            'move.created_at as created_at',
            'move.updated_at as updated_at'
            )->join("users", "move.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("move.date_of_move", "like", "%". $searchValue . "%")
                
                    //User
                    ->orWhere("users.first_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.last_name", "like", "%". $searchValue . "%")
                    ->orWhere("users.gender", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%")

                    // Family
                    ->orWhere("family.number_family", "like", "%". $searchValue . "%")
                    ->orWhere("family.head", "like", "%". $searchValue . "%");
            })->whereBetween('move.created_at', [$date_from, $date_end]);  


        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get()->toArray();

        dd($response);
    }
}
