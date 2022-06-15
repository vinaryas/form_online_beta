<?php

namespace App\Http\Controllers;

use App\Services\Support\cashierService;
use App\Services\Support\rj_serverService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class rj_server_statusController extends Controller
{
    public function index(){
        $rj = rj_serverService::getAll( UserService::authStoreArray())->get();

        return view('rj_server_void.index', compact('rj'));
    }

    public function detail($id){
        $rj =  rj_serverService::getById($id)->first();

        return view('rj_server_void.detail', compact('rj'));
    }

    public function status(Request $request){

        if(isset($_POST['inactive'])){
            $data = [
                'status' => 'I',
            ];

            $inactiveFormOnline = rj_serverService::update($data, $request->id);
            $inactiveMMSoft = cashierService::update($data, $request->id);

            Alert::success('SUCCESS', 'Rj Server Inactive');
            return redirect()->route('rj_server.index');
        }elseif(isset($_POST['active'])){
            $data = [
                'status' => 'A',
            ];

            $inactiveFormOnline = rj_serverService::update($data, $request->id);
            $inactive = cashierService::update($data, $request->id);

            Alert::success('SUCCESS', 'Rj Server Active');
            return redirect()->route('rj_server.index');
        }
    }
}
