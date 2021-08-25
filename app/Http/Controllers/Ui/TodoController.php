<?php

namespace App\Http\Controllers\Ui;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return view('easyui');
    }

    public function pasien()
    {
        return view('Pasien/ranap_covid');
    }

    public function easyUiBasic()
    {
        return view('Todo/basic');
    }

    public function easyUiEditable()
    {
        return view('Todo/editable');
    }

    public function logout()
    {
        return view('logout');
    }
}
