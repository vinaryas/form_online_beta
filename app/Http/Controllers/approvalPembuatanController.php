<?php

namespace App\Http\Controllers;

use App\Services\Support\approvalPembuatanService;
use App\Services\Support\cashierService;
use App\Services\Support\first_time_syncService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\rj_serverService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
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
        $stores = StoreService::all()->get();
        $formPembuatan = formPembuatanService::getById($request->form_pembuatan_id)->first();

        if (isset($_POST["approve"])){
            try{
                $data = [
                    'form_pembuatan_id' => $request->form_pembuatan_id,
                    'approved_by' => Auth::user()->id,
                    'approver_nik'=>Auth::user()->username,
                    'approver_name'=>Auth::user()->name,
                    'approver_role_id' =>  Auth::user()->role_id,
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

                        $first_sync = ['status' => config('setting_app.status_sync.need_sync')];
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

                            $first_sync = ['status' => config('setting_app.status_sync.need_sync')];
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

                            $first_sync = ['status' => config('setting_app.status_sync.need_sync')];
                            $storeOnFormOnline = first_time_syncService::update($first_sync, $store->id);
                        }
                    }
                }
                $dataUpdate = [
                    'role_last_app' =>  Auth::user()->role_id,
                    'role_next_app' => approvalPembuatanService::getNextApp($request->aplikasi_id[0], Auth::user()->role_id, $request->region_id),
                    'status'=> config('setting_app.status_approval.approve'),
                ];
                $updateStatus = formPembuatanService::update($dataUpdate, $storeApprove->form_pembuatan_id);

                $userUpdate = ['status_pembuatan'=> 0, 'store_id'=>$request->store_id];
                $statusUser = userService::update($userUpdate, $request->user_id);

                DB::commit();

                Alert::success('Approved', 'form has been approved');
                return redirect()->route('approval-pembuatan.index');
            }catch(\Throwable $th){
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
                    'approver_role_id' => Auth::user()->role_id,
                    'approver_region_id'=> Auth::user()->region_id,
                    'status' => 'Disapproved'
                ];
                $storeApprove = approvalPembuatanService::store($data);

                $dataUpdate = [
                    'role_last_app' => Auth::user()->role_id,
                    'role_next_app' => 0,
                    'status'=> config('setting_app.status_approval.disapprove'),
                ];
                $updateStatus = formPembuatanService::update($dataUpdate, $storeApprove->form_pembuatan_id);

                $userUpdate = ['status_pembuatan'=> 0,];
                $statusUser = userService::update($userUpdate, $request->user_id);

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


