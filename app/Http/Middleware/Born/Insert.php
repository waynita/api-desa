<?php

namespace App\Http\Middleware\Born;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Born;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Insert extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Born = new Born();
        $this->Model->Born->name = $this->_Request->input('name');
        $this->Model->Born->gender = $this->_Request->input('gender');
        $this->Model->Born->date_of_birth = $this->_Request->input('date_of_birth');
        $this->Model->Born->family_id = $this->_Request->input('family_id');
    }

    protected function validation()
    {
        $this->mergeRules([
            'name' => ['required','string', 'min:1', 'max:20'],
            'gender' => ['required', 'string', 'in:p,l'],
            'date_of_birth' => ['required', 'date:Y-m-d h:i:s'],
            'family_id' => ['required', 'integer', 'exists:App\Models\Family,id']
        ]);
        $validator = Validator::make($this->_Request->all(), $this->Rules);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
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
