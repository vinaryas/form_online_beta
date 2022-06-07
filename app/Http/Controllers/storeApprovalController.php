<?php

namespace App\Http\Controllers;

use App\Services\Support\StoreService;
use App\Services\Support\userService;
use App\Services\Support\UserStoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class storeApprovalController extends Controller
{
    public function index(){
        $user = userService::getUserAreaKordinator()->get();

        return view('store_user.index', compact('user'));
    }

    public function create($id){
        $user = userService::finId($id)->first();
        $stores = StoreService::all()->get();

        return view('store_user.create', compact('user', 'stores'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            $data =[
                'store_id' =>$request->store_id,
                'user_id' =>$request->user_id,
            ];
            $saveData = UserStoreService::store($data, $request->user_id);

            DB::commit();

            return redirect()->route('store.index');
        }catch(\Throwable $th){
            dd($th);
            return redirect()->route('store.index');
        }
    }

    public function detail($userId){
        $data = UserStoreService::getAllStoreFromUserId($userId)->get();

        return view('store_user.detail', compact('data'));
    }

    public function detailDeleteById($storeId){
        $data = UserStoreService::getUserStoreById($storeId)
        ->first();

        return view('store_user.deleteDetail', compact('data'));
    }

    public function delete(Request $request){
        DB::beginTransaction();
        try{
            $deleteData = UserStoreService::deleteByStoreId($request->store_id, $request->user_id);

            DB::commit();

            return redirect()->route('store.index');
        }catch(\Throwable $th){
            dd($th);
            return redirect()->route('store.index');
        }
    }
}
