<?php

namespace App\Http\Controllers;

use App\Services\Support\cashierService;
use App\Services\Support\first_time_syncService;
use App\Services\Support\rj_serverService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class rj_server_statusController extends Controller
{
    public function index(){
        if(Auth::user()->role_id == 2){
            $rj = rj_serverService::getAllStore( UserService::authStoreArray())->get();
        }elseif(Auth::user()->role_id == config('setting_app.role_id.admin')){
            $rj = rj_serverService::getAllBo( UserService::authStoreArray())->get();
        }

        return view('rj_server.index', compact('rj'));
    }

    public function detail($id){
        $rj =  rj_serverService::getById($id)->first();

        return view('rj_server.detail', compact('rj'));
    }

    public function status(Request $request){

        if(isset($_POST['inactive'])){
            $data = [
                'status' => 'I',
            ];

            $inactiveFormOnline = rj_serverService::update($data, $request->id);
            $inactiveMMSoft = cashierService::update($data, $request->id);


            $first_sync = [
                'status' => 1
            ];

            $storeOnFormOnline = first_time_syncService::update($first_sync, $request->store_id);

            Alert::success('SUCCESS', 'Rj Server Inactive');
            return redirect()->route('rj_server.index');
        }elseif(isset($_POST['active'])){
            $data = [
                'status' => 'A',
            ];

            $activeFormOnline = rj_serverService::update($data, $request->id);
            $activeMMSoft = cashierService::update($data, $request->id);

            $first_sync = [
                'status' => 1
            ];

            $storeOnFormOnline = first_time_syncService::update($first_sync, $request->store_id);

            Alert::success('SUCCESS', 'Rj Server Active');
            return redirect()->route('rj_server.index');
        }
    }
}
