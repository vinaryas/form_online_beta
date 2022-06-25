<?php

namespace App\Http\Controllers;

use App\Services\Support\approvalPembuatanService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\form_headService;
use App\Services\Support\userService;
use Carbon\Carbon;
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

        if(Auth::user()->role_id == config('setting_app.role_id.it')){
            $countApproval = formPembuatanService::countApprovalIt(Auth::user()->roles->first()->id, UserService::authStoreArray(), $thisMonth)->get()->count();
        }elseif(Auth::user()->role_id == config('setting_app.role_id.aux')){
            $countApproval = formPembuatanService::getApproveFilterByStore(Auth::user()->roles->first()->id, UserService::authStoreArray(), $thisMonth)->get()->count();
            $countForm = form_headService::countForm(Auth::user()->id, $thisMonth)->get()->count();
            $countApproved = approvalPembuatanService::countApproved(Auth::user()->id, $thisMonth)->get()->count();
            $countDisapproved = approvalPembuatanService::countDisapproved(Auth::user()->id, $thisMonth)->get()->count();
        }elseif(Auth::user()->role_id == config('setting_app.role_id.admin')){
            $countApproval = formPembuatanService::getDetail($thisMonth)->get()->count();
            $countForm = form_headService::countAdmin($thisMonth)->get()->count();
            $countApproved = approvalPembuatanService::countApprovedAdmin($thisMonth)->get()->count();
            $countDisapproved = approvalPembuatanService::countDisapprovedAdmin($thisMonth)->get()->count();
        }else{
            $countForm = form_headService::countForm(Auth::user()->id, $thisMonth)->get()->count();
            $countApproved = approvalPembuatanService::countApproved(Auth::user()->id, $thisMonth)->get()->count();
            $countDisapproved = approvalPembuatanService::countDisapproved(Auth::user()->id, $thisMonth)->get()->count();
        }

        return view('home', compact('countApproval', 'countForm', 'countApproved', 'countDisapproved'));
    }
}
