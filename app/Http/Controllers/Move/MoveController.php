<?php

namespace App\Http\Controllers\Move;

use App\Http\Controllers\Controller;
use App\Support\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoveController extends Controller
{
    public function __construct(Request $Request)
    {
        if ($Request) {
            $this->_Request = $Request;
        }
    }

    public function Insert()
    {
        $Model = $this->_Request->Payload->get('Model');

        DB::beginTransaction();
        try {
            $Model->Move->save();
            $Model->User->save();
            $Model->Population->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Json::set('data', config('callback.insertSuccess'));
        return response()->json(Json::get(), 201);
    }

    public function Update()
    {
        $Model = $this->_Request->Payload->get('Model');

        DB::beginTransaction();
        try {
            $Model->Move->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Json::set('data', config('callback.updateSuccess'));
        return response()->json(Json::get(), 202);
    }

    public function Delete()
    {
        $Model = $this->_Request->Payload->get('Model');

        DB::beginTransaction();
        try {
            $Model->Move->delete();
            $Model->User->save();
            $Model->Population->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Json::set('data', config('callback.deleteSuccess'));
        return response()->json(Json::get(), 202);
    }
}
