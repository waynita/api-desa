<?php

namespace App\Http\Middleware\Move;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Move;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Update extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->Move = Move::where('id', $this->Id)->first();
        if ($this->Model->Move) {
            $this->Model->Move->reason = $this->_Request->input('reason');
            $this->Model->Move->date_of_move = $this->_Request->input('date_of_move');
        }
    }

    protected function validation()
    {
        $this->mergeRules([
            'reason' => ['required', 'string'],
            'date_of_move' => ['required', 'date:Y-m-d h:i:s'],
        ]);
        $validator = Validator::make($this->_Request->all(), $this->Rules);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
            return false;
        }
        if (!isset($this->Model->Move)) {
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
