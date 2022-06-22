<?php

namespace App\Http\Controllers;

use App\Services\Support\aplikasiService;
use App\Services\Support\approvalService;
use App\Services\Support\form_headService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\formHeadService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class formPembuatanController extends Controller
{
    public function index()
    {
        $user = userService::find(Auth::user()->id);
        $thisMonth = Carbon::now()->month;
        if(Auth::user()->role_id == 3){
            $formPembuatan = formPembuatanService::getDetail($thisMonth)->get();
        }else{
            $formPembuatan = formPembuatanService::getFormByUserId(Auth::user()->id, $thisMonth)->get();
        }

        return view('form_pembuatan.index', compact('formPembuatan', 'user'));
    }

    public function detail($id)
    {
        $form = formPembuatanService::getById($id)->first();

        return view('form_pembuatan.detail', compact('form'));
    }

    public function status($id)
    {
        $log = approvalService::getStatusApprovalById($id)->get();

        return view('form_pembuatan.status', compact('log'));
    }

    public function create()
    {
        $user = userService::find(Auth::user()->id);
        $app = aplikasiService::all()->get();

        return view('form_pembuatan.create', compact('user', 'app'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $user = userService::findRoleUser(auth::user()->role_id)->first();

        if(Auth::user()->role_id == 0){
            try {
                $index = 0;
                $dataForm = [
                    'user_id' => $request->user_id,
                    'nik' => $request->nik,
                    'store_id' => $request->store_id,
                    'region_id'=>$request->region_id,
                    'store_id' => $request->store_id,
                ];

                $storeForm = form_headService::store($dataForm);

                foreach ($request->aplikasi_id as $aplikasi_id){

                    $id_vega = ($aplikasi_id == 1) ? $request->id_vega[$index] : null;

                    $pass = ($aplikasi_id >= 1 && $aplikasi_id <= 2) ? $request->pass[$index] : null;

                    $dataApp = [
                        'aplikasi_id' => $aplikasi_id,
                        'form_id' => $storeForm->id,
                        'id_vega'=> $id_vega,
                        'pass'=> $pass,
                        'store' => $storeForm->store_id,
                        'type' => 's',
                        'role_last_app' =>  Auth::user()->role_id,
                        'role_next_app' => form_headService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                        'status' => 0,
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
            elseif(Auth::user()->role_id == 2){
                try {
                    $index = 0;
                    $dataForm = [
                        'user_id' => $request->user_id,
                        'nik' => $request->nik,
                        'store_id' => $request->store_id,
                        'region_id'=>$request->region_id,
                        'store_id' => $request->store_id,
                    ];

                    $storeForm = form_headService::store($dataForm);

                    foreach ($request->aplikasi_id as $aplikasi_id) {

                        $id_vega = ($aplikasi_id == 1) ? $request->id_vega[$index] : null;

                        $pass = ($aplikasi_id >= 1 && $aplikasi_id <= 2) ? $request->pass[$index] : null;

                        $dataApp = [
                            'aplikasi_id' => $aplikasi_id,
                            'form_id' => $storeForm->id,
                            'id_vega'=> $id_vega,
                            'pass'=> $pass,
                            'store' => $storeForm->store_id,
                            'type' => 's',
                            'role_last_app' =>  Auth::user()->role_id,
                            'role_next_app' => form_headService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                            'status' => 1,
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
                    'user_id' => $request->user_id,
                    'nik' => $request->nik,
                    'region_id'=>$request->region_id,
                    'store_id' => $request->store_id,
                ];

                $storeForm = form_headService::store($dataForm);

                foreach ($request->aplikasi_id as $aplikasi_id) {

                    $id_vega = ($aplikasi_id == 1) ? $request->id_vega[$index] : null;

                    $pass = ($aplikasi_id >= 1 && $aplikasi_id <= 2) ? $request->pass[$index] : null;

                    $dataApp = [
                        'aplikasi_id' => $aplikasi_id,
                        'form_id' => $storeForm->id,
                        'id_vega'=> $id_vega,
                        'pass'=> $pass,
                        'store' => $storeForm->store_id,
                        'type' => 'b',
                        'role_last_app' =>  Auth::user()->role_id,
                        'role_next_app' => 1,
                        // 'role_next_app' => form_headService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                        'status' => 1,
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

