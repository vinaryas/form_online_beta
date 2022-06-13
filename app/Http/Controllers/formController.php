<?php

namespace App\Http\Controllers;

use App\Services\Support\aplikasiService;
use App\Services\Support\approvalService;
use App\Services\Support\formAplikasiService;
use App\Services\Support\formService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class formController extends Controller
{
    public function index()
    {
        $thisMonth = Carbon::now()->month;
        $user = UserService::find(Auth::user()->id);
        if(Auth::user()->role_id == 3){
            $formAplikasi = formAplikasiService::adminViewForm($thisMonth)->get();
        }else{
            $formAplikasi = formAplikasiService::getFormByUserId(Auth::user()->id, $thisMonth)->get();
        }

        return view('form.index', compact('formAplikasi', 'user'));
    }

    public function status($id){
        $history = approvalService::getStatusApprovalById($id)
        ->orderBy('history_approval.created_at', 'ASC')
        ->get();

        return view('form.status', compact('history'));
    }

    public function create()
    {
        $user = userService::find(Auth::user()->id);
        $app = aplikasiService::all()->get();
        $stores = StoreService::all()->get();

        return view('form.create', compact('user', 'app', 'stores'));
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
                    'username' => $request->username,
                    'store_id' => $request->store_id,
                    'region_id'=>$request->region_id,
                    'dapartemen_id' => $request->dapartemen_id,
                ];

                $storeForm = formService::store($dataForm);

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
                        'role_next_app' => formService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                        'status' => 0,
                        'created_by' => Auth::user()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $storeFormApp = formAplikasiService::store($dataApp);

                    $index++;
                }

                DB::commit();

                Alert::success('succes', 'form berhasil disimpan');
                return redirect()->route('form.index');
                }catch (\Throwable $th){
                    dd($th);
                    Alert::error('Error!!',);
                    return redirect()->route('form.index');
                }
            }
            elseif(Auth::user()->role_id == 2){
                try {
                    $index = 0;
                    $dataForm = [
                        'user_id' => $request->user_id,
                        'username' => $request->username,
                        'store_id' => $request->store_id,
                        'region_id'=>$request->region_id,
                        'dapartemen_id' => $request->dapartemen_id,
                    ];

                    $storeForm = formService::store($dataForm);

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
                            'role_next_app' => formService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                            'status' => 1,
                            'created_by' => Auth::user()->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $storeFormApp = formAplikasiService::store($dataApp);

                        $index++;
                    }

                    DB::commit();

                    Alert::success('succes', 'form berhasil disimpan');
                    return redirect()->route('form.index');
                    }catch (\Throwable $th){
                        dd($th);
                        Alert::error('Error!!',);
                        return redirect()->route('form.index');
                    }
            }
            else{
            try {
                $index = 0;
                $dataForm = [
                    'user_id' => $request->user_id,
                    'username' => $request->username,
                    'region_id'=>$request->region_id,
                    'dapartemen_id' => $request->dapartemen_id,
                ];

                $storeForm = formService::store($dataForm);

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
                        // 'role_next_app' => formService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id),
                        'status' => 1,
                        'created_by' => Auth::user()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $storeFormApp = formAplikasiService::store($dataApp);

                    $index++;
                }
                DB::commit();

                Alert::success('succes', 'form berhasil disimpan');
                return redirect()->route('form.index');
                }catch (\Throwable $th){
                    dd($th);
                    Alert::error('Error!!',);
                    return redirect()->route('form.index');
                }
        }
    }

}

