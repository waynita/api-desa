<?php

namespace App\Http\Controllers\Born;

use App\Http\Controllers\Controller;
use App\Models\Born;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BornBrowseController extends Controller
{

    use Datatables;

    public function Anything(Request $request){
        $this->datatables($request);
        $searchValue = $this->searchValue;
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay();
        $date_end = Carbon::parse($request->get('date_end'))->endOfDay();

        $response['count'] = Born::select('count(*) as allcount')
            ->join("family", "born.family_id", "family.id")->whereBetween('born.created_at', [$date_from, $date_end]);

        $response['totalRecordswithFilter'] = Born::join("family", "born.family_id", "family.id")
            ->where(function ($query) use ($searchValue) {
                $query->where("born.name", "like", "%". $searchValue . "%")
                    ->orWhere("born.gender", "like", "%". $searchValue . "%")
                    ->orWhere("born.date_of_birth", "like", "%". $searchValue . "%")
                    ->orWhere("family.number_family", "like", "%". $searchValue . "%");
            })->whereBetween('born.created_at', [$date_from, $date_end]);
                            
        $response['records'] = Born::orderBy($this->columnName,$this->columnSortOrder)->select(
            'born.id as id',
            'born.name as name',
            'born.gender as gender',
            'born.date_of_birth as date_of_birth',

            // Family
            'family.number_family as number_family',

            // Born
            'born.created_at as created_at',
            'born.updated_at as updated_at'
            )->join("family", "born.family_id", "family.id")->where(function ($query) use ($searchValue) {
                $query->where("born.name", "like", "%". $searchValue . "%")
                    ->orWhere("born.gender", "like", "%". $searchValue . "%")
                    ->orWhere("born.date_of_birth", "like", "%". $searchValue . "%")
                    ->orWhere("family.number_family", "like", "%". $searchValue . "%");
            })->whereBetween('born.created_at', [$date_from, $date_end]);  

        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get();
        $data_arr = array();

        foreach($response['records'] as $record){
            $id = $record->id;
            $name = $record->name;
            $date_of_birth = $record->date_of_birth;
            $gender = ($record->gender == 'l') ? 'Laki - Laki' : 'Perempuan';
            $family = $record->number_family . " - " . $record->head;
            $action = '<a type="button" onClick="deletes('. $id .')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "date_of_birth" => $date_of_birth,
                "gender" => $gender,
                "family" => $family,
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
