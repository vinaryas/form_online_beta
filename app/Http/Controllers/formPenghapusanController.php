<?php

namespace App\Http\Controllers;

use App\Models\logFormPenghapusan;
use App\Services\formPenghapusanService as ServicesFormPenghapusanService;
use App\Services\Support\alasanPenghapusanService;
use App\Services\Support\aplikasiService;
use App\Services\Support\approvalPembuatanService;
use App\Services\Support\form_headService;
use App\Services\Support\formLogService;
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
            $form = userService::getUserStore(
                UserService::authStoreArray()
                )->get();
        }

        return view('form_penghapusan.index', compact('form', 'user'));
    }

    public function create($userId){
        $users = userService::getById($userId)->first();
        $alasan = alasanPenghapusanService::all()->get();
        $app = aplikasiService::all()->get();

        return view('form_penghapusan.create', compact('users', 'alasan', 'app'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        $user = userService::findRoleUser(auth::user()->role_id)->first();

        try{
            $index = 0;
            $form = [
                'created_by' =>  Auth::user()->id,
                'nik' => Auth::user()->username,
                'region_id'=>Auth::user()->region_id,
            ];

            $storeForm = form_headService::store($form);

            foreach ($request->aplikasi_id as $aplikasi_id){
                $data = [
                    'aplikasi_id' => $aplikasi_id,
                    'form_id' => $storeForm->id,
                    'store' => $request->store_id_asal,
                    'type' => 's',
                    'role_last_app' =>  Auth::user()->role_id,
                    'role_next_app' => approvalPembuatanService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                    'status' => config('setting_app.status_approval.panding'),
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $storeOnFormPenghapusan = formPenghapusanService::store($data);

                $logForm = [
                    'nik' => Auth::user()->username,
                    'nama' => Auth::user()->name,
                    'aplikasi_id' => $aplikasi_id,
                    'proses' =>config('setting_app.proses_form_id.penghapusan'),
                    'id_toko' =>  $request->store_id,
                    'alasan' => $request->alasan_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $storelog = formLogService::store($logForm);

                $index++;
            }

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
