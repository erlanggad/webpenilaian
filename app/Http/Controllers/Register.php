<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Karyawan;

class Register extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        if (Karyawan::create($request->all())) {
            return redirect('/login')->with('success', 'Berhasil membuat karyawan');
        } else {
            return redirect('/login')->with('failed', 'Gagal membuat karyawan');
        }
    }
}