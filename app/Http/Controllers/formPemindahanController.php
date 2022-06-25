<?php

namespace App\Http\Controllers;

use App\Services\Support\aplikasiService;
use App\Services\Support\approvalPembuatanService;
use App\Services\Support\form_headService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\formPenghapusanService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class formPemindahanController extends Controller
{
    public function index(){
        $form = formPembuatanService::getFormByUserId(Auth::user()->id)->get();

        return view('form_pemindahan.index', compact('form'));
    }

    public function create(){
        $user = userService::find(Auth::user()->id);
        $app = aplikasiService::all()->get();
        $stores = StoreService::all()->get();

        return view('form_pemindahan.create', compact('user', 'app', 'stores'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        $user = userService::findRoleUser(auth::user()->role_id)->first();

        if(Auth::user()->role_id == config('setting_app.role_id.kasir')){
            try {
                $index = 0;
                $dataForm = [
                    'created_by' => Auth::user()->id,
                    'nik' => Auth::user()->username,
                    'region_id'=> Auth::user()->region_id,
                ];

                $storeForm = form_headService::store($dataForm);

                foreach ($request->aplikasi_id as $aplikasi_id){
                    $id_vega = ($aplikasi_id == config('setting_app.aplikasi_id.vega')) ? $request->id_vega[$index] : null;
                    $pass = ($aplikasi_id >= config('setting_app.aplikasi_id.vega') && $aplikasi_id <= config('setting_app.aplikasi_id.rjserver')) ? $request->pass[$index] : null;
                    $data = [
                        'aplikasi_id' => $aplikasi_id,
                        'form_id' => $storeForm->id,
                        'id_vega'=> $id_vega,
                        'pass'=> $pass,
                        'store' => $request->store_id_asal,
                        'type' => 's',
                        'role_last_app' =>  Auth::user()->role_id,
                        'role_next_app' => approvalPembuatanService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                        'status' => config('setting_app.status_approval.panding'),
                        'created_by' => Auth::user()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $storeOnFormPembuatan = formPembuatanService::store($data);

                    $index++;
                }
                foreach ($request->aplikasi_id as $aplikasi_id){
                    $data = [
                        'aplikasi_id' => $aplikasi_id,
                        'form_id' => $storeForm->id,
                        'store' => $request->store_id_tujuan,
                        'type' => 's',
                        'role_last_app' =>  Auth::user()->role_id,
                        'role_next_app' => approvalPembuatanService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                        'status' => config('setting_app.status_approval.panding'),
                        'created_by' => Auth::user()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $storeOnFormPenghapusan = formPenghapusanService::store($data);

                    $index++;
                }

                DB::commit();

                Alert::success('succes', 'form berhasil disimpan');
                return redirect()->route('form-pembuatan.index');
                }catch (\Throwable $th){
                    dd($th);
                    Alert::error('Error!!',);
                    return redirect()->route('form-pembuatan.index');
                }
            }
            elseif(Auth::user()->role_id == config('setting_app.role_id.aux')){
                try {
                    $index = 0;
                    $dataForm = [
                        'created_by' =>  Auth::user()->id,
                        'nik' => $request->nik,
                        'store_id' => $request->store_id,
                        'region_id'=>$request->region_id,
                    ];

                    $storeForm = form_headService::store($dataForm);

                    foreach ($request->aplikasi_id as $aplikasi_id) {

                        $id_vega = ($aplikasi_id == config('setting_app.aplikasi_id.vega')) ? $request->id_vega[$index] : null;

                        $pass = ($aplikasi_id >= config('setting_app.aplikasi_id.vega') && $aplikasi_id <= config('setting_app.aplikasi_id.rjserver')) ? $request->pass[$index] : null;

                        $dataApp = [
                            'aplikasi_id' => $aplikasi_id,
                            'form_id' => $storeForm->id,
                            'id_vega'=> $id_vega,
                            'pass'=> $pass,
                            'store' => $storeForm->store_id,
                            'type' => 's',
                            'role_last_app' =>  Auth::user()->role_id,
                            'role_next_app' => approvalPembuatanService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                            'status' =>  config('setting_app.status_approval.approve'),
                            'created_by' => Auth::user()->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $storeFormApp = formPembuatanService::store($dataApp);

                        $index++;
                    }

                    DB::commit();

                    Alert::success('succes', 'form berhasil disimpan');
                    return redirect()->route('form-pembuatan.index');
                    }catch (\Throwable $th){
                        dd($th);
                        Alert::error('Error!!',);
                        return redirect()->route('form-pembuatan.index');
                    }
            }
            else{
            try {
                $index = 0;
                $dataForm = [
                    'created_by' =>  Auth::user()->id,
                    'nik' => $request->nik,
                    'store_id' => $request->store_id,
                    'region_id'=>$request->region_id,
                ];

                $storeForm = form_headService::store($dataForm);

                foreach ($request->aplikasi_id as $aplikasi_id) {

                    $id_vega = ($aplikasi_id == config('setting_app.aplikasi_id.vega')) ? $request->id_vega[$index] : null;

                    $pass = ($aplikasi_id >= config('setting_app.aplikasi_id.vega') && $aplikasi_id <= config('setting_app.aplikasi_id.rjserver')) ? $request->pass[$index] : null;

                    $dataApp = [
                        'aplikasi_id' => $aplikasi_id,
                        'form_id' => $storeForm->id,
                        'id_vega'=> $id_vega,
                        'pass'=> $pass,
                        'store' => $storeForm->store_id,
                        'type' => 'b',
                        'role_last_app' =>  Auth::user()->role_id,
                        'role_next_app' => config('setting_app.role_id.it'),
                        'status' => config('setting_app.status_approval.approve'),
                        'created_by' => Auth::user()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $storeFormApp = formPembuatanService::store($dataApp);

                    $index++;
                }

                DB::commit();

                Alert::success('succes', 'form berhasil disimpan');
                return redirect()->route('form-pembuatan.index');
                }catch (\Throwable $th){
                    dd($th);
                    Alert::error('Error!!',);
                    return redirect()->route('form-pembuatan.index');
                }
        }
    }
}
