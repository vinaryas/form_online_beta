<?php

namespace App\Http\Controllers;

use App\Services\Support\approvalPenghapusanService;
use App\Services\Support\first_time_syncService;
use App\Services\Support\formPenghapusanService;
use App\Services\Support\logFormPenghapusanService;
use App\Services\Support\rj_serverService;
use App\Services\Support\userService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class approvalPenghapusanController extends Controller
{
    public function index(){
        $thisMonth = Carbon::now()->month;
        if(Auth::user()->role_id == config('setting_app.role_id.admin')){
            $form = formPenghapusanService::adminViewApproval($thisMonth)->get();
        }else{
            if(Auth::user()->all_store == 'y'){
                $form = formPenghapusanService::getApproveFilter(
                    Auth::user()->roles->first()->id, $thisMonth)
                ->get();
            }else{
                $form = formPenghapusanService::getApproveFilterByStore(
                    Auth::user()->roles->first()->id, userService::authStoreArray(), $thisMonth)
                ->get();
            }
        }

        return view('approval_penghapusan.index', compact('form'));
    }

    public function detail($id){
        $forms = formPenghapusanService::getById($id)->first();
        $authApp = approvalPenghapusanService::isApprovalExitst($id, Auth::user()->role_id, $forms->region_id);

        return view('approval_penghapusan.create', compact('forms', 'authApp'));
    }

    public function approve(Request $request){
    	DB::beginTransaction();
        $nextApp = approvalpenghapusanService::getNextApp($request->aplikasi_id[0], Auth::user()->role_id, $request->region_id);
        $formPenghapusan = formPenghapusanService::getById($request->form_penghapusan_id)->first();

        if (isset($_POST["approve"]))
        {
            try{
                $data = [
                    'form_penghapusan_id' => $request->form_penghapusan_id,
                    'approved_by' => Auth::user()->id,
                    'approver_nik'=>Auth::user()->username,
                    'approver_name'=>Auth::user()->name,
                    'approver_role_id' =>Auth::user()->role_id,
                    'approver_region_id'=> Auth::user()->region_id,
                    'status' => 'Approved'
                ];

                $storeApprove = approvalpenghapusanService::store($data);

                if($formPenghapusan->aplikasi_id == config('setting_app.aplikasi_id.rjserver'))
                {
                    if($formPenghapusan->role_last_app ==  config('setting_app.role_id.kasir')){
                        $rjServer =  formPenghapusanService::getRjServerStore()->first();
                        dd($rjServer);

                        $dataPos = [
                            'status' => 'I',
                        ];

                        $storeOnFormOnline = rj_serverService::update($dataPos);


                        $first_sync = [
                            'status' => config('setting_app.status_sync.need_sync')
                        ];

                        $storeOnFormOnline = first_time_syncService::update($first_sync, $request->store_id);

                    }
                }

                $dataUpdate = [
                    'role_last_app' => Auth::user()->role_id,
                    'role_next_app' => $nextApp,
                    'status'=> config('setting_app.status_approval.approve'),
                ];

                $updateStatus = formPenghapusanService::update($dataUpdate, $storeApprove->form_penghapusan_id);

                DB::commit();

                Alert::success('Approved', 'form has been approved');
                return redirect()->route('approval-penghapusan.index');
            } catch (\Throwable $th) {
                DB::rollback();

                dd($th->getMessage());
                Alert::error('Error!!',);
                return redirect()->route('approval-penghapusan.index');
            }
        }elseif (isset($_POST["disapprove"])){
            try{
                $data = [
                    'form_penghapusan_id' => $request->form_penghapusan_id,
                    'approved_by' => Auth::user()->id,
                    'approver_nik'=>Auth::user()->username,
                    'approver_name'=>Auth::user()->name,
                    'approver_role_id' => Auth::user()->role_id,
                    'approver_region_id'=> Auth::user()->region_id,
                    'status' => 'Disapproved'
                ];

                $storeApprove = approvalpenghapusanService::store($data);

                $dataUpdate = [
                    'role_last_app' => Auth::user()->role_id,
                    'role_next_app' => 0,
                    'status'=> config('setting_app.status_approval.disapprove'),
                ];

                $updateStatus = formPenghapusanService::update($dataUpdate, $storeApprove->form_penghapusan_id);

                DB::commit();

                Alert::warning('Disapproved', 'form has been disapproved');
                return redirect()->route('approval-penghapusan.index');
            }catch (\Throwable $th) {
                DB::rollback();

                dd($th->getMessage());
                Alert::error('Error!!',);
                return redirect()->route('approval-penghapusan.index');
            }
        }
    }
}
