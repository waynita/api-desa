<?php

namespace App\Http\Middleware\Comer;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Comer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Update extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Comer = Comer::where('id', $this->Id)->first();
        if ($this->Model->Comer) {
            $this->Model->Comer->nik = $this->_Request->input('nik');
            $this->Model->Comer->name = $this->_Request->input('name');
            $this->Model->Comer->gender = $this->_Request->input('gender');
            $this->Model->Comer->date_of_come = $this->_Request->input('date_of_come');
            $this->Model->Comer->whistleblower_id = $this->_Request->input('whistleblower_id');
        }
    }

    protected function validation()
    {
        $this->mergeRules([
            'nik' => ['required','string', 'min:1', 'max:17'],
            'name' => ['required', 'string', 'min:1', 'max:150'],
            'gender' => ['required', 'string', 'in:p,l'],
            'date_of_come' => ['required', 'date:Y-m-d h:i:s'],
            'whistleblower_id' => ['required', 'integer', 'exists:App\Models\User,id']
        ]);
        $validator = Validator::make($this->_Request->all(), $this->Rules);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
            return false;
        }
        if (!isset($this->Model->Comer)) {
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
