<?php

namespace App\Http\Controllers\Link;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class LinkController extends Controller
{
    public function Anything($data = null)
    {
        $Data = $this->LeftSection(); 

        $Pages = $this->FilterSubMenu($data);
        $Parent = $this->GetParent($Pages['FilterMenu']->slug);
        $Url = $Pages['FilterMenu']->file;
        if (isset($Pages['SubMenu'])) {
            $Url = $Pages['FilterMenu']->file . "." . $Pages['SubMenu'];
        }
        
        return view($Url)->with(compact('Data', 'Pages', 'Parent'));
    }

    public function Page($data)
    {
        $FilterMenu = Menu::where('url', $data)->first();
        return view("$FilterMenu->file");
    }

    private function LeftSection()
    {
        $FilterParent = Menu::where('parent_id', null)->get()->toArray();

        return array_map(function($Values) {
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
    }

    private function FilterSubMenu($data = null) 
    {
        $Data = explode('/', str_replace(' ', '', $data));

        $Datas['FilterMenu'] = $this->GetMenu("/");
        if (!in_array("", $Data, true)) {
            $Datas = array(
                'FilterMenu' => $this->GetMenu($Data[0])
            );
            if (isset($Data[1])) {
                $Datas = array(
                    'FilterMenu' => $this->GetMenu($Data[0]),
                    'SubMenu' => ucfirst($Data[1])
                );
            }   
            if (isset($Data[2])) {
                $Datas['Id'] = $Data[2];
            }
        }

        return $Datas;
    }

    private function GetChild($id)
    {
        $FilterChild = Menu::where('parent_id', $id)->get()->toArray();
        $Datas['child'] = $FilterChild;
        return $Datas;
    }

    private function GetParent($Slug)
    {
        $Parent = Menu::where('slug', $Slug)->first();
        if (!empty($Parent->parent_id)) {
            $Parent = Menu::where('id', $Parent->parent_id)->first();
        }
        return $Parent;
    }

    private function GetMenu($url = null)
    {
        $FilterMenu = Menu::where('url', $url)->first();
        return $FilterMenu;
    }
}
