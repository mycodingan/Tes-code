<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dasController extends Controller
{
    public function index()
    {
        $kelasWithSiswa = Kelas::with('siswa')->get();
        $kelasWithGuru = Kelas::with('guru')->get();
        $siswaFull = Siswa::with(['kelas', 'guru'])->get();

        return view('das', compact('kelasWithSiswa', 'kelasWithGuru', 'siswaFull'));
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect(route('login'));
    }
}
