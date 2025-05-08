<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;

class dasController extends Controller
{
    public function index()
    {
        $kelasWithSiswa = Kelas::with('siswa')->get();
        $kelasWithGuru = Kelas::with('guru')->get();
        $siswaFull = Siswa::with(['kelas', 'guru'])->get();

        return view('das', compact('kelasWithSiswa', 'kelasWithGuru', 'siswaFull'));
    }
}
