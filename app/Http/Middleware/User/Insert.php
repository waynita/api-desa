<?php

namespace App\Http\Middleware\User;

use App\Http\Middleware\BaseMiddleware;
use App\Models\Population;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class Insert extends BaseMiddleware
{
    protected function initiate() 
    {
        $this->Model->User = new User;
        $this->Model->User->name = $this->_Request->input('nama');
        $this->Model->User->username = $this->generateRandomString();
        $this->Model->User->email = $this->generateRandomString() . "@mail.com";
        $this->Model->User->password = md5($this->generateRandomString());
        $this->Model->User->birthdate = $this->_Request->input('tanggalLahir');
        $this->Model->User->position_id = 4;

        $this->Model->Population = new Population();
        $this->Model->Population->nik = $this->_Request->input('nik');
        $this->Model->Population->place_of_birth = $this->_Request->input('tempatLahir');
        $this->Model->Population->gender = $this->_Request->input('jenisKelamin');
        $this->Model->Population->village = $this->_Request->input('desa');
        $this->Model->Population->neighbourhood = $this->_Request->input('rt');
        $this->Model->Population->hamlet = $this->_Request->input('rw');
        $this->Model->Population->religion = $this->_Request->input('agama');
        $this->Model->Population->married = $this->_Request->input('statusPerkawinan');
        $this->Model->Population->occupation = $this->_Request->input('pekerjaan');
    }

    private function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function validation()
    {
        $this->mergeRules([
            'nama' => ['required','string', 'min:1', 'max:150'],
            'nik' => ['required', 'string', 'min:1', 'max:20', 'unique:App\Models\Population,nik'],
            'tempatLahir' => ['required', 'min:1', 'max:150'],
            'jenisKelamin' => ['required', 'in:l,p'],
            'desa' => ['required', 'string', 'min:1', 'max:150'],
            'rt' => ['required', 'integer'],
            'rw' => ['required', 'integer'],
            'agama' => ['required', 'string', 'min:1', 'max:150'],
            'statusPerkawinan' => ['required', 'string', 'min:1', 'max:150'],
            'pekerjaan' => ['required', 'string', 'min:1', 'max:150']
        ]);
        $validator = FacadesValidator::make($this->_Request->all(), $this->Rules);
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
