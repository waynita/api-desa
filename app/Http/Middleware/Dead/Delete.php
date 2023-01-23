<?php

namespace App\Http\Middleware\Dead;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Dead;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Delete extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Dead = Dead::where('id', $this->Id)->first();
        if ($this->Model->Dead) {
            $this->Model->User = User::where('id', $this->Model->Dead->user_id)->first();
            if ($this->Model->User) {
                $this->Model->User->status = 'active';
                $this->Model->Population = Population::where('user_id', $this->Model->Dead->user_id)->first();
                if ($this->Model->Population) {
                    $this->Model->Population->status = 'ada';
                }
            }
        }
    }

    protected function validation()
    {
        $this->mergeRules([ 'id' => 'required' ]);
        $validator = Validator::make([ 'id' => $this->Id ], $this->Rules);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
            return false;
        }
        if (!isset($this->Model->Dead)) {
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
