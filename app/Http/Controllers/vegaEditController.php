<?php

namespace App\Http\Controllers;

use App\Services\Support\formAplikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class vegaEditController extends Controller
{
    public function index(){
        $vega = formAplikasiService::getVega()->get();

        return view('vega_void.index', compact('vega'));
    }

    public function edit($id){
        $vega = formAplikasiService::getById($id)->first();

        return view('vega_void.edit', compact('vega'));
    }

    public function update(Request $request){
        DB::beginTransaction();

        if(isset($_POST["update"]))
        {
            try{
                $data = [
                    'id_vega' => $request->id_vega,
                    'pass' => $request->pass,
                ];

                $updateData = formAplikasiService::update($data, $request->form_aplikasi_id);

                DB::commit();

                Alert::success('succes', 'berhasil diupdate');
                return redirect()->route('vega.index');
            }catch(\Throwable $th){
                dd($th);
                return redirect()->route('vega.index');
            }
        }elseif(isset($_POST["delete"])){
            try{

                $delete = formAplikasiService::deleteData($request->form_aplikasi_id);

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
