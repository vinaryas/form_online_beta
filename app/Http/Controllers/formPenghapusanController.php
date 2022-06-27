<?php

namespace App\Http\Controllers;

use App\Models\logFormPenghapusan;
use App\Services\Support\alasanPenghapusanService;
use App\Services\Support\aplikasiService;
use App\Services\Support\approvalPembuatanService;
use App\Services\Support\form_headService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\formPenghapusanService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
use App\Services\Support\UserStoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class formPenghapusanController extends Controller
{
    public function index(){
        $user = userService::find(Auth::user()->id);
        if(Auth::user()->role_id == config('setting_app.role_id.admin')){
            $form = userService::getDetail()->get();
        }elseif(Auth::user()->role_id == config('setting_app.role_id.aux')){
            $form = userService::getUserStore(UserService::authStoreArray())->get();
        }

        return view('form_penghapusan.index', compact('form', 'user'));
    }

    public function create(){
        $users = UserService::all()->get();
        $stores = StoreService::all()->get();
        $alasan = alasanPenghapusanService::all()->get();
        $app = aplikasiService::all()->get();

        return view('form_penghapusan.create', compact('users', 'stores', 'alasan', 'app'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        $user = userService::findRoleUser(auth::user()->role_id)->first();

        try{
            $index = 0;
            $dataForm = [
                'created_by' =>  Auth::user()->id,
                'nik' => Auth::user()->username,
                'store_id' =>Auth::user()->store_id,
                'region_id'=>Auth::user()->region_id,
            ];

            $storeForm_head = form_headService::store($dataForm);
            $storeLog_form_penghapusan = logFormPenghapusan::create($dataForm);

                $dataPenghapusan = [
                    'log_form_penghapusan_id' => $storeLog_form_penghapusan->id,
                    'deleted_user_id' => $request->user_id,
                    'deleted_nik' => $request->nik,
                    'store' => $request->store_id,
                    'type' => 's',
                    'role_last_app' =>  Auth::user()->role_id,
                    'role_next_app' => approvalPembuatanService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeLog_form_penghapusan->region_id),
                    'status' => config('setting_app.status_approval.panding'),
                ];

                $storeDataPenghapusan = formPenghapusanService::store($dataPenghapusan);

                $index++;

            $dataUser = [
                'store_id' => null,
            ];

            $updateDataUser = userService::update($dataUser, $request->user_id);

            DB::commit();

            Alert::success('succes', 'form berhasil disimpan');
            return redirect()->route('form-penghapusan.index');
        }catch(\Throwable $th){

            dd($th);
            Alert::error('Error!!',);
            return redirect()->route('form-penghapusan.index');
        }
    }
}
