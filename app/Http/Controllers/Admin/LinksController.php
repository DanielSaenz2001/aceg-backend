<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Link;
use App\Models\Admin\LinkRole;
use App\Models\Admin\LinkUser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LinksController extends Controller
{
    public function index()
    {
        $data = Link::paginate(20);

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = Link::findOrFail($id);

        return response()->json($data, 200);
    }

    public function create(Request $request)
    {
        $miTiempo = Carbon::now();

        $link = new Link();
        $link->link     = $request->link;
        $link->orden    = $request->orden;
        $link->padre_id = $request->padre_id;

        $link->usuario      = auth()->user()->usuario;
        $link->creado       = $miTiempo;
        $link->modificado   = $miTiempo;

        $link->save();

        return response()->json($link, 200);
    }

    public function update(Request $request, $id)
    {
        $miTiempo = Carbon::now();

        $link = Link::findOrFail($id);
        $link->link     = $request->link;
        $link->orden    = $request->orden;

        $link->usuario      = auth()->user()->usuario;
        $link->modificado   = $miTiempo;

        $link->save();

        return response()->json($link, 200);
    }

    public function destroy($id)
    {
        $data = Link::findOrFail($id)->delete();

        return response()->json($data, 200);
    }

    /* Links Roles And Users */

    public function getRoles($id){

        $data = LinkRole::where('link_id', $id)->paginate(20);

        return response()->json($data, 200);
    }

    public function getUsers($id){

        $data = LinkUser::where('link_id', $id)->paginate(20);

        return response()->json($data, 200);
    }

    public function createRoles(Request $request)
    {
        $miTiempo = Carbon::now();

        $link = new LinkRole();
        $link->link_id  = $request->link_id;
        $link->role_id  = $request->role_id;

        $link->usuario      = auth()->user()->usuario;
        $link->creado       = $miTiempo;
        $link->modificado   = $miTiempo;

        $link->save();

        return response()->json($link, 200);
    }

    public function destroyRoles($id)
    {
        $data = LinkRole::findOrFail($id)->delete();

        return response()->json($data, 200);
    }

    public function createUsers(Request $request)
    {
        $miTiempo = Carbon::now();

        $link = new LinkUser();
        $link->link_id  = $request->link_id;
        $link->user_id  = $request->user_id;

        $link->usuario      = auth()->user()->usuario;
        $link->creado       = $miTiempo;
        $link->modificado   = $miTiempo;

        $link->save();

        return response()->json($link, 200);
    }

    public function destroyUsers($id)
    {
        $data = LinkUser::findOrFail($id)->delete();

        return response()->json($data, 200);
    }
}
