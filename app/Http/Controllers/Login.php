<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\models\Admin;
use App\models\Pejabat_struktural;
use App\models\Karyawan;
use App\Models\Pegawai;

class Login extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function login_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $request->session()->flash('failed', 'Lengkapi isian form');
            return redirect('login');
        }

        // $karyawan = Karyawan::where([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        // $check = $this->checkUser($request, $karyawan, 'Karyawan');
        // if($check != null){
        //     return $check;
        // }

        // $staf_hr = Pejabat_struktural::where([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        // $check = $this->checkUser($request, $staf_hr, 'pejabat-struktural');
        // if($check != null){
        //     return $check;
        // }

        $pegawai = Pegawai::where([
            'email' => $request->email,
            'password' => $request->password,
        ])->with('divisi', 'jabatan')->first();

        if ($pegawai) {

            $check = $this->checkUser($request, $pegawai, $pegawai->jabatan->nama);
            // dd($check);

            if ($check != null) {
                return $check;
            }
        }



        $admin = Admin::where([
            'email' => $request->email,
            'password' => $request->password,
        ])->first();

        // dd($admin);

        $check = $this->checkUser($request, $admin, 'admin');
        if ($check != null) {
            return $check;
        }

        return redirect('/')->with('failed', 'Data User Tidak Ditemukan');
    }

    private function checkUser($request, $user, $role)
    {
        // Session::flush();
        // dd($user);

        if ($user) {

            // $user = $user->first()->toArray();
            // unset($user['password']);
            $user['role'] = $role;
            $user['id'] = $user['id'] ?? $user['id_admin'];
            $user['nama'] = $user['nama_admin'] ?? $user['nama_pejabat_struktural'] ?? $user['nama_pegawai'];
            $user['divisi'] = $user['divisi_id'] ?? null;
            Session(['user' => $user]);
            // dd($role);
            switch ($role) {
                case 'karyawan':
                    return redirect('/karyawan/home');
                    break;

                    // case 'Karyawan':
                    //     return redirect('/karyawan/home');
                    //     break;
                case 'Kepala Bagian':
                    return redirect('/kepala-bagian/home');
                    break;

                case 'Kepala Sub Bagian':
                    return redirect('/kepala-sub-bagian/home');
                    break;

                case 'Direktur':
                    return redirect('/direktur/home');
                    break;

                    // case 'Manager':
                    //     return redirect('/pejabat-struktural/home');
                    //     break;

                case 'admin':
                    return redirect('/admin/home');
                    break;

                default:
                    return redirect('/')->with('failed', 'Data User Tidak Ditemukan');
                    break;
            }
        } else {
            return redirect('/')->with('failed', 'Data User Tidak Ditemukan');;
        }
    }

    public function logout_action()
    {
        Session::flush();
        // dd(Session('user'));

        return redirect('/login');
    }
}
