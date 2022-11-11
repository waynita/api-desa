<?php

namespace App\Http\Middleware\Family;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Family;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Validator;

class Update extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Family = Family::where('id', $this->Id)->first();
        if ($this->Model->Family) {
            $this->Model->Family->number_family = $this->_Request->input('number_family');
            $this->Model->Family->village = $this->_Request->input('village');
            $this->Model->Family->neighbourhood = $this->_Request->input('neighbourhood');
            $this->Model->Family->hamlet = $this->_Request->input('hamlet');
            $this->Model->Family->sub_districts = $this->_Request->input('sub_districts');
            $this->Model->Family->districts = $this->_Request->input('districts');
            $this->Model->Family->province = $this->_Request->input('province');
        }
        
        $this->Model->User = User::where('id', $this->_Request->input('user_id'))->first();
        if ($this->Model->User) {
            $this->Model->Family->head_id = $this->Model->User->id;
        }
        $this->Model->Population = Population::where('user_id', $this->_Request->input('user_id'))->first();
        if ($this->Model->Population) {
            $this->Model->Population->relation = "Kepala Keluarga";
        }
    }

    protected function validation()
    {
        $this->mergeRules([
            'number_family' => ['string', 'min:1', 'max:20', 'unique:App\Models\Family,number_family,' . $this->Id . ',id'],
            'village' => ['string', 'min:1', 'max:150'],
            'neighbourhood' => ['integer'],
            'hamlet' => ['integer'],
            'sub_districts' => ['string', 'min:1', 'max:150'],
            'districts' => ['string', 'min:1', 'max:150'],
            'province' => ['string', 'min:1', 'max:150'],
            'user_id' => ['integer', 'exists:App\Models\User,id']
        ]);
        $validator = Validator::make($this->_Request->all(), $this->Rules);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
            return false;
        }
        if (!isset($this->Model->User)) {
            $this->Json::set('errors', config('callback.userNotFound'));
            return false;
        }

        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
