<?php

namespace App\Http\Controllers;

use App\Services\Support\formPembuatanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class vegaEditController extends Controller
{
    public function index(){
        $vega = formPembuatanService::getVega()->get();

        return view('vega.index', compact('vega'));
    }

    public function edit($id){
        $vega = formPembuatanService::getById($id)->first();

        return view('vega.edit', compact('vega'));
    }

    public function update(Request $request){
        DB::beginTransaction();

        if(isset($_POST["update"]))
        {
            try{
                $data = [
                    'user_id' => $request->user_id,
                    'pass' => $request->pass,
                ];

                $updateData = formPembuatanService::update($data, $request->form_pembuatan_id);

                DB::commit();

                Alert::success('succes', 'berhasil diupdate');
                return redirect()->route('vega.index');
            }catch(\Throwable $th){
                dd($th);
                return redirect()->route('vega.index');
            }
        }elseif(isset($_POST["delete"])){
            try{

                $delete = formPembuatanService::deleteData($request->form_pembuatan_id);

                DB::commit();

                Alert::error('succes', 'form berhasil dihapus');
                return redirect()->route('vega.index');
            }catch(\Throwable $th){
                dd($th);
                return redirect()->route('vega.index');
            }
        }
    }

}
