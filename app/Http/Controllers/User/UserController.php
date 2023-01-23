<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
            $Model->User->save();
            $Id = $Model->User->id;
            $Model->Population->user_id = $Id;
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
            $Model->User->save();
            $Model->Population->save();
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
            $Model->User->delete();
            $Model->Population->delete();

            if (isset($Model->Family)) {
                $Model->Family->delete();
                foreach ($Model->UserChild as $val) {
                User::where('id', $val->id)->update(['family_id' => null]);
                }
                $Model->PopulationChild->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Json::set('data', config('callback.deleteSuccess'));
        return response()->json(Json::get(), 202);
    }
}
