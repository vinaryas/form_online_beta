<?php

namespace App\Http\Controllers;

use App\Services\Support\userService;
use GuzzleHttp\Client;
use RealRashid\SweetAlert\Facades\Alert;

class firstSyncController extends Controller
{
    public function create(){
        $client = new Client();
        $url = 'http://127.0.0.1:8000/api/user/';
        $response = $client->request('GET', $url,  [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        $arrays= json_decode($response->getBody(), true);

        return view('register.register', compact('arrays'));
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
            return redirect()->route('login');
        }catch(\Throwable $th){
            dd($th);
            Alert::error('Error !!!');
            return redirect()->route('login');
        }
    }
}

