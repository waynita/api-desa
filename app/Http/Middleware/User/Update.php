<?php

namespace App\Http\Middleware\User;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Validator;

class Update extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->User = User::where('id', $this->Id)->first();
        if ($this->Model->User) {
            $this->Model->User->name = $this->_Request->input('nama');
            $this->Model->User->birthdate = $this->_Request->input('tanggalLahir');
            $this->Model->User->position_id = 4;

            $this->Model->Population = Population::where('user_id', $this->Id)->first();
            if ($this->Model->Population) {
                $this->Model->Population->nik = $this->_Request->input('nik');
                $this->Model->Population->place_of_birth = $this->_Request->input('tempatLahir');
                $this->Model->Population->gender = $this->_Request->input('jenisKelamin');
                $this->Model->Population->village = $this->_Request->input('desa');
                $this->Model->Population->address = $this->_Request->input('alamat');
                $this->Model->Population->neighbourhood = $this->_Request->input('rt');
                $this->Model->Population->hamlet = $this->_Request->input('rw');
                $this->Model->Population->religion = $this->_Request->input('agama');
                $this->Model->Population->married = $this->_Request->input('statusPerkawinan');
                $this->Model->Population->occupation = $this->_Request->input('pekerjaan');
            }
        }
        
    }

    protected function validation()
    {
        if (!isset($this->Model->Population)) {
            $this->Json::set('errors', config('callback.userDenyEdit'));
            return false;
        }

        $this->mergeRules([
            'nama' => ['string', 'min:1', 'max:150'],
            'nik' => ['string', 'min:1', 'max:20', 'unique:App\Models\Population,nik,' . $this->Model->Population->id . 'id'],
            'tempatLahir' => ['min:1', 'max:150'],
            'jenisKelamin' => ['in:l,p'],
            'desa' => [ 'string', 'min:1', 'max:150'],
            'rt' => ['integer'],
            'rw' => ['integer'],
            'alamat' => ['string', 'min:1', 'max:191'],
            'agama' => ['string', 'min:1', 'max:150'],
            'statusPerkawinan' => ['string', 'min:1', 'max:150'],
            'pekerjaan' => ['string', 'min:1', 'max:150']
        ]);
        $validator = Validator::make($this->_Request->all(), $this->Rules);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
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
