<?php

namespace App\Http\Middleware;

use App\Support\Client;
use App\Support\Json;
use Closure;
use Illuminate\Http\Request;

class BaseMiddleware
{
    protected $_Request;
    protected $Model;
    protected $Payload;
    protected $Id = null;
    protected $RealId = null;
    protected $Username = null;
    protected $Status = null;

    public function __construct(Request $request)
    {

        //print_r($request->toArray());exit;
        if (isset($request->id)) {
            $this->RealId = $request->id;
            if (strpos(strtolower($request->id), 'inv') !== false || strpos(strtolower($request->id), 'gpa') !== false) {
                $this->Id = $request->id;
            }else{
                $this->Id = (int)$request->id;
            }
        }
        if (isset($request->uid)) {
            $this->UID = $request->uid;
        }
        if (isset($request->_id)) {
            $this->_Id = $request->_id;
        }
        if (isset($request->username)) {
            $this->Username = $request->username;
        }
        if (isset($request->status)) {
            $this->Status = $request->status;
        }
        $this->Rules = [];
        $this->Changes = [];
        $this->Json = Json::class;
        $this->HttpCode = 400;
        $this->Model = (object)[];
        $this->Payload = collect([]);
        $this->_Request = $request;
        $this->errors = collect([]);
        $this->MimesVideo = ['octet-stream', 'flv', 'mp4', '3gp', 'mov', 'avi', 'wmv','m3u8'];
        $this->ProviderSocial = ['facebook', 'google', 'apple'];
    }

    public function mergeRules($rules)
    {
        $this->Rules = array_merge($this->Rules, $rules);
    }

    public function mergeChanges($changes)
    {
        $this->Changes = array_merge($this->Changes, $changes);
        $this->Payload->put('Changes', $this->Changes);
    }

    public function setRequest($request)
    {
        $this->_Request = $request;
    }

    public function mergeRequest($key, $data = [])
    {
        return $this->_Request;
    }

    protected function transAttribute($key) {
        return trans('validation.attributes.' . $key);
    }

    public function is_updated($thing) {
        return isset($this->Payload->all()['Changes'][$thing]);
    }
    
}
