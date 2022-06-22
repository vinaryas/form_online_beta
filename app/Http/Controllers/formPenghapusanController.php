<?php

namespace App\Http\Controllers;

use App\Services\Support\form_headService;
use App\Services\Support\formPembuatanService;
use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class formPenghapusanController extends Controller
{
    public function index(){
        $user = userService::find(Auth::user()->id);
        $form = userService::getDetail()->get();

        return view('form_penghapusan.index', compact('form', 'user'));
    }

    public function create($userId){
        $user = userService::getById($userId)->first();

        return view('form_penghapusan.create', compact('user'));
    }

    public function store(){

    }
}
