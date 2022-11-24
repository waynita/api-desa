<?php

namespace App\Http\Controllers\Family;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyController extends Controller
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
            $Model->Family->save();
            $Id = $Model->Family->id;
            $Model->User->family_id = $Id;
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
            $Model->Family->save();
            $Id = $Model->Family->id;
            $Model->User->family_id = $Id;
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

    public function Add()
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
            $Model->Family->delete();
            foreach ($Model->User as $val) {
               User::where('id', $val->id)->update(['family_id' => null]);
            }
            $Model->Population->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Json::set('data', config('callback.deleteSuccess'));
        return response()->json(Json::get(), 202);
    }
    
    public function DeleteUser()
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

        Json::set('data', config('callback.deleteSuccess'));
        return response()->json(Json::get(), 202);
    }
}
