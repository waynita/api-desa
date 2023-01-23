<?php

namespace App\Http\Middleware\User;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Family;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Validator;

class Delete extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->User = User::where('id', $this->Id)->first();
        $this->Model->Population = Population::where('user_id', $this->Id)->first();

        $this->Model->Family = Family::where('head_id', $this->Id)->first();
        if ($this->Model->Family) {
            $this->Model->UserChild = User::where('family_id', $this->Id)->get();
            $this->Model->PopulationChild = Population::where('user_id', $this->Model->Family->head_id)->first();

            if ($this->Model->PopulationChild) {
                $this->Model->PopulationChild->relation = null;
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
        if (!isset($this->Model->Population)) {
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
