<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\SubMenu;
use Closure;
use Illuminate\Http\Request;

class LinkMiddleware
{
    public function validation($request) 
    { 
        $Data = explode('/', str_replace(' ', '', $request));
        $MappingUrl = array_map(function ($Values, $Key) {
            return $this->GetMenu($Values, $Key);
        }, $Data, array_keys($Data));

        if (in_array(false, $MappingUrl)) {
            return false;
        }
        return true;
    }

    private function GetMenu($Values = null, $Key)
    {
        if (empty($Values)) $Values = '/';
        if ($Key == 0) {
            $Exists = Menu::where('url', $Values)->exists();
            if (!$Exists) {
                return false;
            }
        }
        if ($Key == 1) {
            $Exists = SubMenu::where('name', $Values)->exists();
            if (!$Exists) {
                return false;
            }
        }

        return true;
    }

    public function handle(Request $request, Closure $next)
    {
        $validasi = $this->validation($request->route('query'));
        if (!$validasi) {
            return response()->json(config('callback.page403'));
        }
        return $next($request);
    }
}
