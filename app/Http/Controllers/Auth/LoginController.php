<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\Support\userService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
	{
		return 'username';
	}

    protected function credentials(Request $request)
	{
        if(isset($_POST['sign_in'])){
            return $request->only($this->username(), 'password');
        }elseif(isset($_POST['sync'])){
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

}

