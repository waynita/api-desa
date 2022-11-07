<?php

namespace App\Http\Controllers\Link;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function Anything()
    {
        $FilterParent = Menu::where('parent_id', null)->get()->toArray();

        $Data = array_map(function($Values) {
            $FilterChild = $this->GetChild($Values['id']);
            $Data = array(
                'id' => $Values['id'],
                'name' => $Values['name'],
                'icon' => $Values['icon'],
                'slug' => $Values['slug'],
                'url' => $Values['url'],
                'sorting' => $Values['sorting'],
                'child' => $FilterChild['child']
            );

            return $Data;
        }, $FilterParent);
        
        return view('Modul.Dashboard')->with(compact('Data'));
    }

    private function GetChild($id)
    {
        $FilterChild = Menu::where('parent_id', $id)->get()->toArray();
        $Datas['child'] = $FilterChild;
        return $Datas;
    }
}
