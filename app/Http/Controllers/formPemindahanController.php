<?php

namespace App\Http\Controllers;

use App\Services\Support\aplikasiService;
use App\Services\Support\approvalPembuatanService;
use App\Services\Support\form_headService;
use App\Services\Support\formLogService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\formPemindahanService;
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
        $form = formPemindahanService::getByUserId(Auth::user()->id)->get();

        return view('form_pemindahan.index', compact('form'));
    }

    public function create(){
        $user = userService::find(Auth::user()->id);
        $formPembuatan = formPembuatanService::getFormForPemindahanById(Auth::user()->id, Auth::user()->store_id)->get();
        $stores = StoreService::all()->get();

        return view('form_pemindahan.create', compact('user', 'stores', 'formPembuatan'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        $user = userService::findRoleUser(auth::user()->role_id)->first();

        try {
            $index = 0;
            $form = [
                'created_by' => Auth::user()->id,
                'nik' => Auth::user()->username,
                'region_id'=> Auth::user()->region_id,
            ];
            $storeForm = form_headService::store($form);

            $dataPemindahan = [
                'created_by' => Auth::user()->id,
                'nik' => Auth::user()->username,
                'region_id'=> Auth::user()->region_id,
                'from_store'=> $request->store_id_asal,
                'to_store'=>  $request->store_id_tujuan,
            ];
            $storeDataPemindahan = formPemindahanService::store($dataPemindahan);

            foreach ($request->aplikasi_id as $aplikasi_id){
                $user_id = ($aplikasi_id == config('setting_app.aplikasi_id.vega')) ? $request->id_app[$index] : null;
                $pass = ($aplikasi_id >= config('setting_app.aplikasi_id.vega') && $aplikasi_id <= config('setting_app.aplikasi_id.rjserver')) ? $request->pass[$index] : null;
                $type = (Auth::user()->role_id == config('setting_app.role_id.kasir') ||Auth::user()->role_id == config('setting_app.role_id.aux')) ? 's' : 'b';

                $data = [
                    'aplikasi_id' => $aplikasi_id,
                    'form_id' => $storeForm->id,
                    'user_id'=> $user_id,
                    'pass'=> $pass,
                    'store' => $request->store_id_tujuan,
                    'type' => $type,
                    'role_last_app' =>  Auth::user()->role_id,
                    'role_next_app' => approvalPembuatanService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                    'status' => config('setting_app.status_approval.panding'),
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $storeOnFormPembuatan = formPembuatanService::store($data);

                $logForm = [
                    'nik' => Auth::user()->username,
                    'nama' => Auth::user()->name,
                    'aplikasi_id' => $aplikasi_id,
                    'proses' =>'pembuatan',
                    'id_toko' =>  $request->store_id_tujuan,
                    'alasan' => 'Pemindahan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $storelog = formLogService::store($logForm);

                $index++;
            }
            foreach ($request->aplikasi_id as $aplikasi_id){
                $data = [
                    'aplikasi_id' => $aplikasi_id,
                    'form_id' => $storeForm->id,
                    'store' => $request->store_id_asal,
                    'type' => $type,
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
                    'proses' =>'penghapusan',
                    'id_toko' =>  $request->store_id_asal,
                    'alasan' => 'Pemindahan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $storelog = formLogService::store($logForm);

                $index++;
            }

            $change = ['status_pembuatan' => '1', 'status_penghapusan' => '1'];
            $update = userService::update($change, Auth::user()->id);

            DB::commit();

            Alert::success('succes', 'form berhasil disimpan');
            return redirect()->route('form-pemindahan.index');
        }catch (\Throwable $th){
            dd($th);
            Alert::error('Error!!',);
            return redirect()->route('form-pemindahan.index');
        }
    }
}
