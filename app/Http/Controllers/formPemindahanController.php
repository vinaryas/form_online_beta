<?php

namespace App\Http\Controllers;

use App\Services\Support\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class formPemindahanController extends Controller
{
    public function index(){
        $user = userService::find(Auth::user()->id);
        $form = userService::getDetail()->get();

        return view('form_pemindahan.index', compact('form', 'user'));
    }

    public function create($userId){
        $form = userService::find($userId)->first();

        return view('form_pemindahan.create', compact('form'));
    }

    public function store(){

    }
}
