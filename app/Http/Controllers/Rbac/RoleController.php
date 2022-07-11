<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Services\Support\RoleService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
    public function index(){
        $roles = RoleService::all()->get();

        return view('role.index', compact('roles'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            $data = [
                'name'=>$request->name,
                'display_name'=>$request->display_name,
                'description'=>$request->description,
            ];
            $store = RoleService::store($data);
            DB::commit();
            return redirect()->route('role.index');
        }catch(\Throwable $th){
            dd($th);
        }

    }


}
