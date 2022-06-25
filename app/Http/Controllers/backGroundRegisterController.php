<?php

namespace App\Http\Controllers;

use App\Services\Support\regionService;
use App\Services\Support\RoleService;
use App\Services\Support\roleUserService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class backGroundRegisterController extends Controller
{
    public function index(){
        $regions = regionService::all()->get();
        $roles = RoleService::all()->get();

        return view('backGroundRegister.register', compact('regions', 'roles'));
    }

    public function store(Request $request){
        DB::beginTransaction();

        try{
            $data = [
                'name' => $request->name,
                'username'=> $request->username,
                'region_id' => $request->region_id,
                'role_id'=> $request->role_id,
                'password' => Hash::make($request->password)
            ];

            $storeData =  userService::store($data);

            $userRoleData = [
                'user_id' => $storeData->id,
                'role_id' => $storeData->role_id ,
                'user_type' => 'App\User',
            ];

            $storeUserRoleData = roleUserService::store($userRoleData);

            DB::commit();

            Alert::success('SUCCESS', "Register Berhasil");
            return redirect()->route('home');
        }catch (\Throwable $th){

            dd($th);
            Alert::error('ERROR', "Register Gagal");
            return redirect()->route('home');
        }
    }
}
