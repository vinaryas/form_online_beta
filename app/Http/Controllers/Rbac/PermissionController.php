<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Alert;

use App\Helper\MyHelper;
use App\Services\Support\PermissionService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(){
        $parents = PermissionService::all()->get();

        return view('permission.index', compact('parents'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            $data = [
                'parent_id'=>$request->parent_id,
                'name'=>$request->name,
                'display_name'=>$request->display_name,
                'description'=>$request->description,
            ];
            $store = PermissionService::store($data);
            DB::commit();
            return redirect()->route('permission.index');
        }catch(\Throwable $th){
            dd($th);
        }
    }


}
