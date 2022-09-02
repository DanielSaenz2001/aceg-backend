<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Link;
use App\Models\Admin\PermisoLink;
use App\Models\Admin\Permiso;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LinksController extends Controller
{
    public function index()
    {
        $data = Link::where('padre_id', null)->get();

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $link       = Link::findOrFail($id);
        $childrens  = Link::where('padre_id', $id)->get();

        foreach ($childrens as $children) {
            $permisosLinks = PermisoLink::join('permisos', 'permisos.id', 'permiso_links.permiso_id')
            ->where('permiso_links.link_id', $children->id)
            ->select('permisos.*')->get();

            $linksAvoid = [];

            for ($i=0; $i < count($permisosLinks); $i++) {
                $linksAvoid[$i] = $permisosLinks[$i]['id'];
            }

            $permisos = Permiso::whereNotIn('id', $linksAvoid)->where('activo', true)->get();

            $children->permisosLinks    = $permisosLinks;
            $children->permisos         = $permisos;
        }

        return response()->json([
            'link'          => $link,
            'childrens'     => $childrens,
        ]);
    }

    public function create(Request $request)
    {
        $miTiempo = Carbon::now();

        $link = new Link();
        $link->link     = $request->link;
        $link->orden    = $request->orden;
        $link->icon     = $request->icon;
        $link->visible  = true;
        $link->padre_id = $request->padre_id;

        $link->save();

        return response()->json($link, 200);
    }

    public function update(Request $request, $id)
    {
        $miTiempo = Carbon::now();

        $link = Link::findOrFail($id);
        $link->link     = $request->link;
        $link->icon     = $request->icon;
        $link->visible  = $request->visible;
        $link->orden    = $request->orden;

        $link->save();

        return response()->json($link, 200);
    }

    public function destroy($id)
    {
        $data = Link::findOrFail($id)->delete();

        return response()->json($data, 200);
    }

    /* Links Permisos */

    public function addPermiso($id_link, $id_permiso){
        $plink  = new PermisoLink();

        $plink->permiso_id  = $id_permiso;
        $plink->link_id     = $id_link;
        $plink->save();

        return $this->show($id_link);
    }

    public function deletePermiso($id_link, $id_permiso){
        $plink  = PermisoLink::where('link_id', $id_link)->where('permiso_id', $id_permiso)->first();
        if($plink){
            $plink->delete();
        }else{
            return response()->json([
                'status'    => 'Sin Coincidencia',
                'message'   => 'No se encontro ese registro.'
            ], 404);
        }

        return $this->show($id_link);
    }

}
