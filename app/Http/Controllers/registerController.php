<?php

namespace App\Http\Controllers;

use App\Services\Support\regionService;
use App\Services\Support\roleUserService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class registerController extends Controller
{

    public function index(){
        $register = userService::all()->get();

        return view('', compact('register'));
    }

    public function create(){
        $regions = regionService::all()->get();
        $stores = StoreService::all()->get();

        return view('user.register', compact('regions', 'stores'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $request->request->add(['password' => Hash::make($request->password)]);
        $save = userService::store($request->except('_token'));

        try{
            $data = [
                'user_id' => $save->id,
                'role_id' => '0',
                'user_type' => 'App\User',
            ];

            $storeData = roleUserService::store($data);

            DB::commit();

            Alert::success('SUCCESS', "Register Berhasil");
            return redirect()->route('login');
        }catch(\Throwable $th){
            dd($th);
            Alert::error('ERROR', "Register Gagal");
            return redirect()->route('login');
        }
    }




}

