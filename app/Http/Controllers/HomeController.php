<?php

namespace App\Http\Controllers;

use App\Services\Support\approvalService;
use App\Services\Support\formAplikasiService;
use App\Services\Support\formService;
use App\Services\Support\userService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countApproval = 0;
        $countForm = 0;
        $countApproved = 0;
        $countDisapproved = 0;
        $thisMonth = Carbon::now()->month;

        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $countApproval = formAplikasiService::countApproval(Auth::user()->roles->first()->id, UserService::authStoreArray(), $thisMonth)->get()->count();
            $countForm = formService::countForm(Auth::user()->id, $thisMonth)->get()->count();
            $countApproved = approvalService::countApproved(Auth::user()->id, $thisMonth)->get()->count();
            $countDisapproved = approvalService::countDisapproved(Auth::user()->id, $thisMonth)->get()->count();
        }elseif(Auth::user()->role_id == 3){
            $countApproval = formAplikasiService::countAplikasiForAdmin($thisMonth)->get()->count();
            $countForm = formService::countAdmin($thisMonth)->get()->count();
            $countApproved = approvalService::countApprovedAdmin($thisMonth)->get()->count();
            $countDisapproved = approvalService::countDisapprovedAdmin($thisMonth)->get()->count();
        }else{
            $countForm = formService::countForm(Auth::user()->id, $thisMonth)->get()->count();
            $countApproved = approvalService::countApproved(Auth::user()->id, $thisMonth)->get()->count();
            $countDisapproved = approvalService::countDisapproved(Auth::user()->id, $thisMonth)->get()->count();
        }

        $user = userService::find(Auth::user()->id);
        return view('home', compact('user', 'countApproval', 'countForm', 'countApproved', 'countDisapproved'));
    }
}
