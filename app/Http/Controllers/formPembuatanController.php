<?php

namespace App\Http\Controllers;

use App\Services\Support\aplikasiService;
use App\Services\Support\approvalPembuatanService;
use App\Services\Support\form_headService;
use App\Services\Support\formLogService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class formPembuatanController extends Controller
{
    public function index(){
        $user = userService::find(Auth::user()->id);
        $thisMonth = Carbon::now()->month;
        if(Auth::user()->role_id == config('setting_app.role_id.admin')){
            $form = formPembuatanService::getDetail($thisMonth)->get();
        }else{
            $form = formPembuatanService::getFormByUserId(Auth::user()->id, $thisMonth)->get();
        }

        return view('form_pembuatan.index', compact('form', 'user'));
    }

    public function detail($id){
        $form = formPembuatanService::getById($id)->first();

        return view('form_pembuatan.detail', compact('form'));
    }

    public function status($id){
        $log = approvalPembuatanService::getStatusApprovalById($id)->get();

        return view('form_pembuatan.status', compact('log'));
    }

    public function create(){
        $user = userService::find(Auth::user()->id);
        $app = aplikasiService::all()->get();
        $stores = StoreService::all()->get();

        return view('form_pembuatan.create', compact('user', 'app', 'stores'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        $user = userService::findRoleUser(auth::user()->role_id)->first();

        try {
            $index = 0;
            $form = [
                'created_by' => Auth::user()->id,
                'nik' => Auth::user()->username,
                'region_id'=>Auth::user()->region_id,
            ];
            $storeForm = form_headService::store($form);

            foreach ($request->aplikasi_id as $aplikasi_id){
                $user_id = ($aplikasi_id == config('setting_app.aplikasi_id.vega')) ? $request->id_app[$index] : null;
                $pass = ($aplikasi_id >= config('setting_app.aplikasi_id.vega') && $aplikasi_id <= config('setting_app.aplikasi_id.rjserver')) ? $request->pass[$index] : null;
                $type = (Auth::user()->role_id == config('setting_app.role_id.kasir') || Auth::user()->role_id == config('setting_app.role_id.aux')) ? 's' : 'b';
                $nextApp = (Auth::user()->role_id == config('setting_app.role_id.bo')? 2 : approvalPembuatanService::getNextApp($request->aplikasi_id[0], $user->role_id, $storeForm->region_id));

                $dataApp = [
                    'aplikasi_id' => $aplikasi_id,
                    'form_id' => $storeForm->id,
                    'user_id'=> $user_id,
                    'pass'=> $pass,
                    'store' => $request->store_id,
                    'type' => $type,
                    'role_last_app' => Auth::user()->role_id,
                    'role_next_app' => $nextApp,
                    'status' => config('setting_app.status_approval.panding'),
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $storeFormApp = formPembuatanService::store($dataApp);

                $logForm = [
                    'nik' => Auth::user()->username,
                    'nama' => Auth::user()->name,
                    'aplikasi_id' => $aplikasi_id,
                    'proses' => 'pembuatan',
                    'id_toko' =>  $request->store_id,
                    'alasan' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $storelog = formLogService::store($logForm);

                $index++;
            }
            $status = ['status_pembuatan' => '1'];
            $update = userService::update($status, Auth::user()->id);

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

