<?php
namespace App\Http\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin\PermisoUser;

class ModuleData extends Controller
{
    public function __construct()
    {
    }

    public static function getModules($user_id){
        $q = DB::table('permiso_users as pu');
        $q->join('permiso_links as pl', 'pl.permiso_id', "pu.permiso_id");
        $q->join('links as l', 'l.id', "pl.link_id");
        $q->where("pu.user_id", $user_id);
        $q->select('l.*');
        $links = $q->get();

        $data = [];

        $i = 0;
        foreach ($links as $link) {
            $condicional = false;

            $lin = $link;

            while ($condicional == false) {
                $q = DB::table('links as l');
                $q->where("l.id", $lin->padre_id);
                $q->select("l.*");
                $lin = $q->first();

                if(!$lin){
                    $condicional = true;
                    if(!in_array($link, $data))
                    {
                        $data[$i] = $link;
                        $i = $i + 1;
                    }

                }else{
                    if($lin->padre_id == null){
                        $condicional = true;
                        if(!in_array($lin, $data))
                        {
                            $data[$i] = $lin;
                            $i = $i + 1;
                        }
                    }
                }
            }
        }

        foreach ($data as $da) {
            $childrens = PermisoUser::join('permiso_links', 'permiso_links.permiso_id', "permiso_users.permiso_id")
            ->join('links', 'links.id', "permiso_links.link_id")
            ->where('links.padre_id', $da->id)
            ->where('permiso_users.user_id', $user_id)
            ->select('links.*')->get();

            $da->children = [];

            $i = 0;
            foreach ($childrens as $children) {
                $da->children[$i] = [
                    'title'     => $children->nombre,
                    'icon'      => $children->icon,
                    'link'      => $children->link,
                    'hidden'    => $children->visible,
                    'expanded'  => false,
                ];
                $i = $i + 1;
            }
        }
        return $data;
    }
}
