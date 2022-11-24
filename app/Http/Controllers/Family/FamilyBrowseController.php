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

        $response['count'] = Family::select('count(*) as allcount');

        $response['totalRecordswithFilter'] = Family::join('users', 'family.head_id', 'users.id')
            ->where(function ($query) use ($searchValue) {
                $query->where("family.number_family", "like", "%". $searchValue . "%")
                    ->orWhere("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("family.village", "like", "%". $searchValue . "%")
                    ->orWhere("family.neighbourhood", "like", "%". $searchValue . "%")
                    ->orWhere("family.hamlet", "like", "%". $searchValue . "%")
                    ->orWhere("family.sub_districts", "like", "%". $searchValue . "%")
                    ->orWhere("family.districts", "like", "%". $searchValue . "%")
                    ->orWhere("family.province", "like", "%". $searchValue . "%");
            });
                            
        $response['records'] = Family::orderBy($this->columnName,$this->columnSortOrder)->select(
                // family
                'family.id as id',
                'family.number_family as number_family',
                'family.head_id as head_id',
                'family.village as village',
                'family.sub_districts as sub_districts',
                'family.districts as districts',
                'family.province as province',

                // user
                'users.id as user_id',
                'users.name as head'
            )
            ->join('users', 'family.head_id', 'users.id')
            ->where(function ($query) use ($searchValue) {
                $query->where("family.number_family", "like", "%". $searchValue . "%")
                    ->orWhere("users.name", "like", "%". $searchValue . "%")
                    ->orWhere("family.village", "like", "%". $searchValue . "%")
                    ->orWhere("family.neighbourhood", "like", "%". $searchValue . "%")
                    ->orWhere("family.hamlet", "like", "%". $searchValue . "%")
                    ->orWhere("family.sub_districts", "like", "%". $searchValue . "%")
                    ->orWhere("family.districts", "like", "%". $searchValue . "%")
                    ->orWhere("family.province", "like", "%". $searchValue . "%");
            });  

        $response['count'] = $response['count']->count();
        $response['totalRecordswithFilter'] = $response['totalRecordswithFilter']->count();
        $response['records'] = $response['records']->skip($this->start)->take($this->rowperpage)->get();
        $data_arr = array();

        foreach($response['records'] as $record){
            $id = $record->id;
            $number_family = $record->number_family;
            $head = $record->head;
            $village = $record->village;
            $action = '<a href="'. URL('data_keluarga/detail/'. $id) .'" type="button" class="btn btn-primary btn-sm"><i class="fa fa-users"></i></a> <a href="'. URL('data_keluarga/update/'. $id) .'" type="button" class="btn btn-warning btn-sm"><i class="fa fa-pen"></i></a>';
            
            $data_arr[] = array(
                "id" => $id,
                "number_family" => $number_family,
                "head" => $head,
                "village" => $village,
                "action" => $action,
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

    public function getFamily(Request $request)
    {
        $search = $request['search'];
        $user = Family::select(
                // family
                'family.id as id',
                'family.number_family as number_family',
                'family.head_id as head_id',
                'family.village as village',
                'family.sub_districts as sub_districts',
                'family.districts as districts',
                'family.province as province',

                // user
                'users.id as user_id',
                'users.name as head',
                'users.family_id as family_id'            
            )->join(
                'users', 
                'users.id', 
                'family.head_id',
                )
                ->where(function ($query) use ($search) {
                    $query->where("family.number_family", "like", "%". $search . "%")
                        ->orWhere("users.name", "like", "%". $search . "%");
                    })
                    ->orderBy('id')
                    ->simplePaginate(50);
                    
        $res = [];
        foreach($user as $row){
            $res[] = [
                'id' => $row['id'],
                'text'=> $row['head'] . " | " . $row['number_family']
            ];
        }
        $out['results'] = $res;        
        return $out;
    }
}
