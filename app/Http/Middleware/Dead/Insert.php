<?php

namespace App\Http\Middleware\Dead;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Dead;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Insert extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Dead = new Dead();
        $this->Model->Dead->user_id = $this->_Request->input('user_id');
        $this->Model->Dead->cause_of_death = $this->_Request->input('cause_of_death');
        $this->Model->Dead->date_of_death = $this->_Request->input('date_of_death');

        $this->Model->User = User::where('id', $this->Model->Dead->user_id)->first();
        if ($this->Model->User) {
            $this->Model->User->status = 'inactive';
            $this->Model->Population = Population::where('user_id', $this->Model->Dead->user_id)->first();
            if ($this->Model->Population) {
                $this->Model->Population->status = 'meninggal';
            }
        }
    }

    protected function validation()
    {
        $this->mergeRules([
            'user_id' => ['required', 'integer', 'exists:App\Models\User,id', 'unique:App\Models\Dead,user_id'],
            'cause_of_death' => ['required', 'string'],
            'date_of_death' => ['required', 'date:Y-m-d h:i:s'],
        ]);
        $validator = Validator::make($this->_Request->all(), $this->Rules);
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
