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
                    ->orWhere("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%");
            })->whereBetween('comer.created_at', [$date_from, $date_end]);
                            
        $response['records'] = Comer::orderBy($this->columnName,$this->columnSortOrder)->select(
            'comer.id as id',
            'comer.nik as nik',
            'comer.name as name',
            'comer.gender as gender',
            'comer.date_of_come as date_of_come',
            'comer.whistleblower_id as whistleblower_id',
            // user
            'users.name as pelapor',
            'users.birthdate as birthdate',

            'comer.created_at as created_at',
            'comer.updated_at as updated_at'
            )->join("users", "comer.whistleblower_id", "users.id")->where(function ($query) use ($searchValue) {
                $query->where("comer.name", "like", "%". $searchValue . "%")
                    ->orWhere("comer.name", "like", "%". $searchValue . "%")
                    ->orWhere("comer.gender", "like", "%". $searchValue . "%")
                
                    //User
                    ->orWhere("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("users.birthdate", "like", "%". $searchValue . "%");
            })->whereBetween('comer.created_at', [$date_from, $date_end]);  

        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get();
        $data_arr = array();

        foreach($response['records'] as $record){
            $id = $record->id;
            $nik = $record->nik;
            $name = $record->name;
            $gender = $record->gender;
            $date_of_come = $record->date_of_come;
            $pelapor = $record->pelapor;
            $action = "test";
            
            $data_arr[] = array(
                "id" => $id,
                "nik" => $nik,
                "name" => $name,
                "gender" => $gender,
                "date_of_come" => $date_of_come,
                "pelapor" => $pelapor,
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
