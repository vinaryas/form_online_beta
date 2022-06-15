<?php

namespace App\Http\Controllers;

use App\Services\Support\approvalService;
use App\Services\Support\cashierService;
use App\Services\Support\formAplikasiService;
use App\Services\Support\formService;
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
            $formAplikasi = formAplikasiService::adminViewApproval($thisMonth)->get();
        }else{
            if(Auth::user()->all_store == 'y'){
                $formAplikasi = formAplikasiService::getApproveFilter(Auth::user()->roles->first()->id, $thisMonth)->orderBy('form_aplikasi.created_at', 'ASC')->get();
            }else{
                $formAplikasi = formAplikasiService::getApproveFilterByStore(Auth::user()->roles->first()->id, UserService::authStoreArray(), $thisMonth)->orderBy('form_aplikasi.created_at', 'ASC')->get();
            }
        }

        return view('approval.index', compact('formAplikasi', 'user'));
    }

    public function create($id){
        $form = formAplikasiService::getById($id)->first();
        $authApp = approvalService::isApprovalExitst($id, Auth::user()->role_id, $form->region_id);

        return view('approval.create', compact('form', 'authApp'));
    }

    public function approve(Request $request)
    {
    	DB::beginTransaction();
        $authRole = Auth::user()->role_id;
        $store = StoreService::find($request->store)->first();
        $nextApp = formService::getNextApp($request->aplikasi_id[0], $authRole, $request->region_id);
        $formAplikasi = formAplikasiService::getFormAplikasiById($request->form_aplikasi_id)->first();

        if (isset($_POST["approve"]))
        {
            try{
                $data = [
                    'form_aplikasi_id' => $request->form_aplikasi_id,
                    'region_id'=> $request->region_id,
                    'user_id' => Auth::user()->id,
                    'username'=>Auth::user()->username,
                    'name'=>Auth::user()->name,
                    'role_id' => $authRole,
                    'status' => 'Approved'
                ];

                $storeApprove = approvalService::store($data);

                if($formAplikasi->aplikasi_id == config('setting_app.aplikasi_id.rjserver'))
                {
                    if($formAplikasi->role_next_app == 2){
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

                    }elseif($formAplikasi->role_next_app == 1){

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
                    }

                }

                $dataUpdate = [
                    'role_last_app' => $authRole,
                    'role_next_app' => $nextApp,
                    'status'=>1
                ];

                $updateStatus = formAplikasiService::update($dataUpdate, $storeApprove->form_aplikasi_id);

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
                    'form_aplikasi_id' => $request->form_aplikasi_id,
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

                $updateStatus = formAplikasiService::update($dataUpdate, $storeApprove->form_aplikasi_id);

                DB::commit();

                Alert::error('Disapproved', 'form has been disapproved');
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


