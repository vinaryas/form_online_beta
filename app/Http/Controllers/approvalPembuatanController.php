<?php

namespace App\Http\Controllers;

use App\Services\Support\approvalPembuatanService;
use App\Services\Support\bapService;
use App\Services\Support\cashierService;
use App\Services\Support\first_time_syncService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\form_headService;
use App\Services\Support\rj_serverService;
use App\Services\Support\rrakService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
use App\Services\Support\vegaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class approvalPembuatanController extends Controller
{
    public function index(){
        $thisMonth = Carbon::now()->month;
        if(Auth::user()->role_id == config('setting_app.role_id.admin')){
            $form = formPembuatanService::adminViewApproval($thisMonth)->get();
        }else{
            if(Auth::user()->all_store == 'y'){
                $form = formPembuatanService::getApproveFilter(
                    Auth::user()->roles->first()->id, $thisMonth)
                ->orderBy('form_pembuatan.created_at', 'ASC')->get();
            }else{
                $form = formPembuatanService::getApproveFilterByStore(
                    Auth::user()->roles->first()->id, UserService::authStoreArray(), $thisMonth)
                ->orderBy('form_pembuatan.created_at', 'ASC')->get();
            }
        }

        return view('approval_pembuatan.index', compact('form'));
    }

    public function create($id){
        $form = formPembuatanService::getById($id)->first();
        $authApp = approvalPembuatanService::isApprovalExitst($id, Auth::user()->role_id, $form->region_id);

        return view('approval_pembuatan.create', compact('form', 'authApp'));
    }

    public function approve(Request $request){
    	DB::beginTransaction();
        $authRole = Auth::user()->role_id;
        $stores = StoreService::all()->get();
        $nextApp = approvalPembuatanService::getNextApp($request->aplikasi_id[0], $authRole, $request->region_id);
        $formPembuatan = formPembuatanService::getById($request->form_pembuatan_id)->first();

        if (isset($_POST["approve"])){
            try{
                $data = [
                    'form_pembuatan_id' => $request->form_pembuatan_id,
                    'approved_by' => Auth::user()->id,
                    'approver_nik'=>Auth::user()->username,
                    'approver_name'=>Auth::user()->name,
                    'approver_role_id' => $authRole,
                    'approver_region_id'=> Auth::user()->region_id,
                    'status' => 'Approved'
                ];

                $storeApprove = approvalPembuatanService::store($data);
                if($formPembuatan->aplikasi_id == config('setting_app.aplikasi_id.rjserver')){
                    if($formPembuatan->role_last_app ==  config('setting_app.role_id.kasir')){
                        $rjServer =  formPembuatanService::getRjServerStore()->first();

                        $dataPos = [
                            'cashnum' => substr($rjServer->nik, 3),
                            'nama' => $rjServer->name,
                            'password' => $rjServer->pass,
                            'roles' => $rjServer->role_id,
                            'store' => $rjServer->store_id,
                            'status' => 'A',
                            'acc' => 2,
                        ];

                        $storeOnFormOnline = rj_serverService::store($dataPos);

                        $storeOnMMSoft = cashierService::store($dataPos);

                        $first_sync = [
                            'status' => config('setting_app.status_sync.need_sync')
                        ];

                        $storeOnFormOnline = first_time_syncService::update($first_sync, $request->store_id);
                    }elseif($formPembuatan->role_last_app == config('setting_app.role_id.aux')){
                        $rjServer =  formPembuatanService::getRjServerBo()->first();

                            $dataPos = [
                                'cashnum' => substr($rjServer->nik, 3),
                                'nama' => $rjServer->name,
                                'password' => $rjServer->pass,
                                'roles' => $rjServer->role_id,
                                'store' => $rjServer->store_id,
                                'status' => 'A',
                                'acc' => 2,
                            ];

                            $storeInFormOnline = rj_serverService::store($dataPos);

                            $storeInMMSoft = cashierService::store($dataPos);

                            $first_sync = [
                                'status' => config('setting_app.status_sync.need_sync')
                            ];

                            $storeOnFormOnline = first_time_syncService::update($first_sync, $request->store_id);
                    }elseif($formPembuatan->role_last_app == config('setting_app.role_id.bo') ){
                        $rjServer =  formPembuatanService::getRjServerBo()->first();

                        foreach ($stores as $store) {
                            $dataPos = [
                                'cashnum' => substr($rjServer->nik, 3),
                                'nama' => $rjServer->name,
                                'password' => $rjServer->pass,
                                'roles' => $rjServer->role_id,
                                'store' => $store->id,
                                'status' => 'A',
                                'acc' => 2,
                            ];

                            $storeInFormOnline = rj_serverService::store($dataPos);

                            $storeInMMSoft = cashierService::store($dataPos);

                            $first_sync = [
                                'status' => config('setting_app.status_sync.need_sync')
                            ];

                            $storeOnFormOnline = first_time_syncService::update($first_sync, $store->id);
                        }
                    }
                }elseif ($formPembuatan->aplikasi_id == config('setting_app.aplikasi_id.vega')) {
                    if ($formPembuatan->role_last_app == config('setting_app.role_id.bo')){
                        $vega =  formPembuatanService::getVegaStore()->first();

                        foreach ($stores as $store) {
                        $data = [
                            'nik' => $vega->nik,
                            'id_vega' => $vega->id_vega,
                            'pass'=> $vega->pass,
                            'store'=> $vega->store_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $storeData = vegaService::store($data);
                        }
                    }else{
                        $vega =  formPembuatanService::getVegaStore()->first();
                        $data = [
                            'nik' => $vega->nik,
                            'id_vega' => $vega->id_vega,
                            'pass'=> $vega->pass,
                            'store'=> $vega->store_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $storeData = vegaService::store($data);
                    }
                }elseif ($formPembuatan->aplikasi_id == config('setting_app.aplikasi_id.rrak')) {
                    if ($formPembuatan->role_last_app == config('setting_app.role_id.bo')){
                        $rrak =  formPembuatanService::getRrakStore()->first();

                        foreach ($stores as $store) {
                        $data = [
                            'nik' => $rrak->nik,
                            'name' => $rrak->name,
                            'store_id'=> $rrak->store_id,
                            'role_id'=> $rrak->role_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $storeData = rrakService::store($data);
                        }
                    }else{
                        $rrak =  formPembuatanService::getRrakStore()->first();

                        $data = [
                            'nik' => $rrak->nik,
                            'name' => $rrak->name,
                            'store_id'=> $rrak->store_id,
                            'role_id'=> $rrak->role_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $storeData = rrakService::store($data);
                    }
                }elseif ($formPembuatan->aplikasi_id == config('setting_app.aplikasi_id.bap')) {
                    if ($formPembuatan->role_last_app == config('setting_app.role_id.bo')){
                        $bap =  formPembuatanService::getBapStore()->first();

                        foreach ($stores as $store) {
                        $data = [
                            'nik' => $bap->nik,
                            'name' => $bap->name,
                            'store_id'=> $bap->store_id,
                            'role_id'=> $bap->role_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $storeData = bapService::store($data);
                        }
                    }else{
                        $bap =  formPembuatanService::getBapStore()->first();

                        $data = [
                            'nik' => $bap->nik,
                            'name' => $bap->name,
                            'store_id'=> $bap->store_id,
                            'role_id'=> $bap->role_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $storeData = bapService::store($data);
                    }
                }

                $dataUpdate = [
                    'role_last_app' => $authRole,
                    'role_next_app' => $nextApp,
                    'status'=> config('setting_app.status_approval.approve'),
                ];

                $updateStatus = formPembuatanService::update($dataUpdate, $storeApprove->form_pembuatan_id);

                if($formPembuatan->role_id ==  config('setting_app.role_id.kasir')){
                    $change = [
                        'store_id' => $formPembuatan->store_id,
                    ];

                    $changeStoreOnUsersTable = userService::update($change, $formPembuatan->user_id);
                }

                DB::commit();

                Alert::success('Approved', 'form has been approved');
                return redirect()->route('approval-pembuatan.index');
            } catch (\Throwable $th) {
                DB::rollback();

                dd($th->getMessage());
                Alert::error('Error!!',);
                return redirect()->route('approval-pembuatan.index');
            }
        }elseif (isset($_POST["disapprove"])){
            try{
                $data = [
                    'form_pembuatan_id' => $request->form_pembuatan_id,
                    'region_id'=> $request->region_id,
                    'approved_by' => Auth::user()->id,
                    'approver_nik'=>Auth::user()->username,
                    'approver_name'=>Auth::user()->name,
                    'approver_role_id' => $authRole,
                    'approver_region_id'=> Auth::user()->region_id,
                    'status' => 'Disapproved'
                ];

                $storeApprove = approvalPembuatanService::store($data);

                $dataUpdate = [
                    'role_last_app' => $authRole,
                    'role_next_app' => 0,
                    'status'=> config('setting_app.status_approval.disapprove'),
                ];

                $updateStatus = formPembuatanService::update($dataUpdate, $storeApprove->form_pembuatan_id);

                DB::commit();

                Alert::warning('Disapproved', 'form has been disapproved');
                return redirect()->route('approval-pembuatan.index');
            }catch (\Throwable $th) {
                DB::rollback();

                dd($th->getMessage());
                Alert::error('Error!!',);
                return redirect()->route('approval-pembuatan.index');
            }
        }
    }
}


