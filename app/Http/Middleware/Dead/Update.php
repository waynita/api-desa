<?php

namespace App\Http\Middleware\Dead;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Dead;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Update extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Dead = Dead::where('id', $this->Id)->first();
        if ($this->Model->Dead) {
            $this->Model->Dead->cause_of_death = $this->_Request->input('cause_of_death');
            $this->Model->Dead->date_of_death = $this->_Request->input('date_of_death');
        }
    }

    protected function validation()
    {
        $this->mergeRules([
            'cause_of_death' => ['required', 'string'],
            'date_of_death' => ['required', 'date:Y-m-d h:i:s'],
        ]);
        $validator = Validator::make($this->_Request->all(), $this->Rules);
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
