<?php

namespace App\Http\Controllers\FirstSync;

use App\Http\Controllers\Controller;
use App\Services\Support\userService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class adminSyncController extends Controller
{
    public function index(){
        return view('firstTimeSync.adminSync');
    }

    public function sync(){
        $client = new Client();
        $url = 'http://127.0.0.1:8000/api/user';

        try{
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
            $arrays= json_decode($response->getBody(), true);

            foreach($arrays['data'] as $array){
                $data = [
                    'name'=> $array['name'],
                    'username'=>$array['id'],
                    'region_id'=>$array['region_id'],
                    'role_id'=>$array['role_id'],
                    'email'=>$array['email'],
                    'password'=>$array['password2'],
                ];

                $store = userService::store($data);
            }

            Alert::success('Berhasil','Store berhasil di download dari server');
            return redirect()->route('roleSync');
        }catch(\Throwable $th){
            dd($th);
            Alert::error('Error !!!');
            return redirect()->route('roleSync');
        }
    }
}
