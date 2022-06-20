<?php

namespace App\Http\Controllers;

use App\Services\Support\approvalService;
use App\Services\Support\cashierService;
use App\Services\Support\first_time_syncService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\form_headService;
use App\Services\Support\rj_serverService;
use App\Services\Support\StoreService;
use App\Services\Support\userService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class approvalController extends Controller
{
    public function index(){
        $user = UserService::find(Auth::user()->id);
        $thisMonth = Carbon::now()->month;
        if(Auth::user()->role_id == 3){
            $formPembuatan = formPembuatanService::adminViewApproval($thisMonth)->get();
        }else{
            if(Auth::user()->all_store == 'y'){
                $formPembuatan = formPembuatanService::getApproveFilter(Auth::user()->roles->first()->id, $thisMonth)->orderBy('form_pembuatan.created_at', 'ASC')->get();
            }else{
                $formPembuatan = formPembuatanService::getApproveFilterByStore(Auth::user()->roles->first()->id, UserService::authStoreArray(), $thisMonth)->orderBy('form_pembuatan.created_at', 'ASC')->get();
            }
        }

        return view('approval.index', compact('formPembuatan', 'user'));
    }

    public function create($id){
        $form = formPembuatanService::getById($id)->first();
        $authApp = approvalService::isApprovalExitst($id, Auth::user()->role_id, $form->region_id);

        return view('approval.create', compact('form', 'authApp'));
    }

    public function approve(Request $request)
    {
    	DB::beginTransaction();
        $authRole = Auth::user()->role_id;
        $stores = StoreService::all()->get();
        $nextApp = form_headService::getNextApp($request->aplikasi_id[0], $authRole, $request->region_id);
        $formPembuatan = formPembuatanService::getformPembuatanById($request->form_pembuatan_id)->first();

        if (isset($_POST["approve"]))
        {
            try{
                $data = [
                    'form_pembuatan_id' => $request->form_pembuatan_id,
                    'region_id'=> $request->region_id,
                    'user_id' => Auth::user()->id,
                    'username'=>Auth::user()->username,
                    'name'=>Auth::user()->name,
                    'role_id' => $authRole,
                    'status' => 'Approved'
                ];

                $storeApprove = approvalService::store($data);

                if($formPembuatan->aplikasi_id == config('setting_app.aplikasi_id.rjserver'))
                {
                    if($formPembuatan->role_last_app === 0){
                        $getPos =  cashierService::getPosStore()->first();

                        $dataPos = [
                            'cashnum' => substr($getPos->username, 3),
                            'nama' => $getPos->name,
                            'password' => $getPos->pass,
                            'roles' => $getPos->role_id,
                            'store' => $getPos->store_id,
                            'status' => 'A',
                            'acc' => 2,
                        ];

                        $storeOnFormOnline = rj_serverService::store($dataPos);

                        $storeOnMMSoft = cashierService::store($dataPos);

                        $first_sync = [
                            'status' => 1
                        ];

                        $storeOnFormOnline = first_time_syncService::update($first_sync, $request->store_id);

                    }elseif($formPembuatan->role_last_app == 2){
                        $getPos =  cashierService::getPosBO()->first();

                            $dataPos = [
                                'cashnum' => substr($getPos->username, 3),
                                'nama' => $getPos->name,
                                'password' => $getPos->pass,
                                'roles' => $getPos->role_id,
                                'store' => $getPos->store_id,
                                'status' => 'A',
                                'acc' => 2,
                            ];

                            $storeInFormOnline = rj_serverService::store($dataPos);

                            $storeInMMSoft = cashierService::store($dataPos);

                            $first_sync = [
                                'status' => 1
                            ];

                            $storeOnFormOnline = first_time_syncService::update($first_sync, $request->store_id);

                    }elseif($formPembuatan->role_last_app == 4 ){
                        $getPos =  cashierService::getPosBO()->first();

                        foreach ($stores as $store) {

                            $dataPos = [
                                'cashnum' => substr($getPos->username, 3),
                                'nama' => $getPos->name,
                                'password' => $getPos->pass,
                                'roles' => $getPos->role_id,
                                'store' => $store->id,
                                'status' => 'A',
                                'acc' => 2,
                            ];

                            $storeInFormOnline = rj_serverService::store($dataPos);

                            $storeInMMSoft = cashierService::store($dataPos);

                            $first_sync = [
                                'status' => 1
                            ];

                            $storeOnFormOnline = first_time_syncService::update($first_sync, $store->id);
                        }

                    }

                }

                $dataUpdate = [
                    'role_last_app' => $authRole,
                    'role_next_app' => $nextApp,
                    'status'=>1
                ];

                $updateStatus = formPembuatanService::update($dataUpdate, $storeApprove->form_pembuatan_id);

                DB::commit();

                Alert::success('Approved', 'form has been approved');
                return redirect()->route('approval.index');
            } catch (\Throwable $th) {
                DB::rollback();

                dd($th->getMessage());
                Alert::error('Error!!',);
                return redirect()->route('approval.index');
            }
        }
        elseif (isset($_POST["disapprove"])){
            try
            {
                $data = [
                    'form_pembuatan_id' => $request->form_pembuatan_id,
                    'region_id'=> $request->region_id,
                    'user_id' => Auth::user()->id,
                    'username'=>Auth::user()->username,
                    'name'=>Auth::user()->name,
                    'role_id' => $authRole,
                    'status' => 'Disapproved'
                ];

                $storeApprove = approvalService::store($data);

                $dataUpdate = [
                    'role_last_app' => $authRole,
                    'role_next_app' => 0,
                    'status'=>2
                ];

                $updateStatus = formPembuatanService::update($dataUpdate, $storeApprove->form_pembuatan_id);

                DB::commit();

                Alert::warning('Disapproved', 'form has been disapproved');
                return redirect()->route('approval.index');
            }catch (\Throwable $th) {
                DB::rollback();

                dd($th->getMessage());
                Alert::error('Error!!',);
                return redirect()->route('approval.index');
            }
        }
    }
}


