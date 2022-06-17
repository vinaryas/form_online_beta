<?php

namespace App\Http\Controllers;


use App\Services\Support\RoleService;
use App\Services\Support\roleUserService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class roleApprovalController extends Controller
{
    public function index(){
        $user = userService::getDetail()->get();

        return view('role_user.index', compact('user'));
    }

    public function create($id){
        $user = userService::finId($id)->first();
        $roles = RoleService::all()->get();

        return view('role_user.create', compact('user', 'roles'));
    }

    public function update(Request $request){

        DB::beginTransaction();

        if(isset($_POST["save"]))
        {
            try{
                if($request->role_id == 2 || $request->role_id == 0){
                    $data =[
                        'role_id' =>$request->role_id,
                        'all_store' =>'n',
                    ];

                    $updateData = userService::update($data, $request->user_id);
                }
                else{
                    $data =[
                        'role_id' =>$request->role_id,
                        'all_store' =>'y',
                    ];

                    $updateData = userService::update($data, $request->user_id);
                }

                $roleUser = [
                    'role_id' => $request->role_id,
                ];

                $updateRole = roleUserService::update($roleUser, $request->user_id);

                DB::commit();

                Alert::success('Success', 'role change');
                return redirect()->route('role.index');
            }catch(\Throwable $th){
                dd($th);
                return redirect()->route('role.index');
            }
        }elseif(isset($_POST["delete"])){
            try{
                $data =[
                    'role_id' => null,
                ];

                $deletRole = userService::update($data, $request->user_id);

                DB::commit();

                Alert::warning('Deleted', 'role deleted');
                return redirect()->route('role.index');
            }catch(\Throwable $th){
                dd($th);
                return redirect()->route('role.index');
            }
        }
    }
}
