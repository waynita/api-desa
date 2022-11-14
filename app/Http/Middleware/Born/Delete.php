<?php

namespace App\Http\Middleware\Born;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Born;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Delete extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Born = Born::where('id', $this->Id)->first();
    }

    protected function validation()
    {
        $this->mergeRules([ 'id' => 'required' ]);
        $validator = Validator::make([ 'id' => $this->Id ], $this->Rules);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
            return false;
        }
        if (!isset($this->Model->Born)) {
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
