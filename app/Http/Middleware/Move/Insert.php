<?php

namespace App\Http\Middleware\Move;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Move;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Insert extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Move = new Move();
        $this->Model->Move->user_id = $this->_Request->input('user_id');
        $this->Model->Move->reason = $this->_Request->input('reason');
        $this->Model->Move->date_of_move = $this->_Request->input('date_of_move');

        $this->Model->User = User::where('id', $this->Model->Move->user_id)->where('status', 'active')->first();
        if ($this->Model->User) {
            $this->Model->User->status = 'inactive';
            $this->Model->Population = Population::where('user_id', $this->Model->Move->user_id)->first();
            if ($this->Model->Population) {
                $this->Model->Population->status = 'pindah';
            }
        }
    }

    protected function validation()
    {
        $this->mergeRules([
            'user_id' => ['required', 'integer', 'exists:App\Models\User,id', 'unique:App\Models\Move,user_id'],
            'reason' => ['required', 'string'],
            'date_of_move' => ['required', 'date:Y-m-d h:i:s'],
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
