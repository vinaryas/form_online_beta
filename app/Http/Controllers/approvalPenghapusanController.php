<?php

namespace App\Http\Controllers;

use App\Services\Support\formPenghapusanService;
use App\Services\Support\logFormPenghapusanService;
use Illuminate\Http\Request;

class approvalPenghapusanController extends Controller
{
    public function index(){
        $form = logFormPenghapusanService::getDetail()->get();

        return view('approval_penghapusan.index', compact('form'));
    }

    public function detail($formPenghapusan){
        $form = logFormPenghapusanService::getById($formPenghapusan)->first();
        $detailPenghapusan = formPenghapusanService::getDetaiilFormPenghapusan($formPenghapusan)->first();


        return view('approval_penghapusan.create', compact('form', 'detailPenghapusan'));
    }
}
