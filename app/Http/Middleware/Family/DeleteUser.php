<?php

namespace App\Http\Middleware\Family;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Family;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeleteUser extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->User = User::where('id', $this->Id)->first();
        if ($this->Model->User) {
            $this->Model->User->family_id = null;
            $this->Model->Population = Population::where('user_id', $this->Model->User->id)->first();

            if ($this->Model->Population) {
                $this->Model->Population->relation = null;
            }
        }
    }

    protected function validation()
    {
        $this->mergeRules([ 'id' => 'required | exists:App\Models\User,id',  ]);
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
