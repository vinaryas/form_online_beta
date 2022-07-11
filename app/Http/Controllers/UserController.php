<?php

namespace App\Http\Controllers;

use App\Services\Support\regionService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(){
        $users = userService::getDetail()->get();

        return view('user_management.index', compact('users'));
    }

    public function edit($id){
        $users = userService::finId($id)->first();
        $regions = regionService::all()->get();

        return view('user_management.edit', compact('users', 'regions'));
    }

    public function update(Request $request){
        DB::beginTransaction();

        if(isset($_POST["update"]))
        {
            try{
                $data = [
                    'name' => $request->name,
                    'username' => $request->username,
                    'region_id'=> $request->region_id,
                ];

                $updatData = userService::update($data, $request->user_id);

                DB::commit();

                Alert::success('succes', 'berhasil diupdate');
                return redirect()->route('management.index');
            }catch(\Throwable $th){
                dd($th);
                return redirect()->route('management.index');
            }
        }elseif(isset($_POST["delete"])){
            try{

                $delet = userService::deleteData($request->user_id);

                DB::commit();

                Alert::error('succes', 'form berhasil dihapus');
                return redirect()->route('management.index');
            }catch(\Throwable $th){
                dd($th);
                return redirect()->route('management.index');
            }
        }
    }

}
