<?php

namespace App\Http\Controllers;

use App\Services\Support\dapartemenService;
use App\Services\Support\regionService;
use App\Services\Support\roleUserService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller
{

    public function index(){
        $register = userService::all()->get();

        return view('', compact('register'));
    }

    public function create(){
        $regions = regionService::all()->get();
        $dapartemens = dapartemenService::all()->get();

        return view('user.register', compact('regions', 'dapartemens'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $request->request->add(['password' => Hash::make($request->password)]);
        $save = userService::store($request->except('_token', 'password_confirmation'));

        try{
            $data = [
                'user_id' => $save->id,
                'role_id' => '0',
                'user_type' => 'App\User',
            ];

            $storeData = roleUserService::store($data);

            DB::commit();

            return redirect()->route('login');
        }catch(\Throwable $th){

            return redirect()->route('login');
        }
    }




}

