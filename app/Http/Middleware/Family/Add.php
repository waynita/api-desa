<?php

namespace App\Http\Middleware\Family;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Family;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Validator;

class Add extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Family = Family::where('id', $this->Id)->first();
        if ($this->Model->Family) {
            $this->Model->User = User::where('id', $this->_Request->input('user_id'))->where('family_id', null)->where('status', 'active')->first();
            if ($this->Model->User) {
                $this->Model->User->family_id = $this->Model->Family->id;
            }

            $this->Model->Population = Population::where('user_id', $this->_Request->input('user_id'))->first();
            if ($this->Model->Population) {
                $this->Model->Population->relation = $this->_Request->input('hubungan');
            }
        }
    }

    protected function validation()
    {
        $this->mergeRules([
            'hubungan' => ['string', 'min:1', 'max:150'],
            'user_id' => ['integer', 'exists:App\Models\User,id']
        ]);
        $validator = Validator::make($this->_Request->all(), $this->Rules);

        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
            return false;
        }

        if (!isset($this->Model->Family)) {
            $this->Json::set('errors', config('callback.familyNotFound'));
            return false;
        }
        if (!isset($this->Model->Population)) {
            $this->Json::set('errors', config('callback.userNotFound'));
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
