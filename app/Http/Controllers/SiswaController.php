<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $siswa = Siswa::with('kelas', 'guru')->get();
            return response()->json($siswa);
        }

        return view('siswa');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_absen' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'nama_siswa' => 'required'
        ]);
        try {
            $siswa = Siswa::create([
                'nomor_absen' => $request->nomor_absen,
                'kelas_id' => $request->kelas_id,
                'guru_id' => $request->guru_id,
                'nama_siswa' => $request->nama_siswa
            ]);
            return response()->json(['success' => true, 'data' => $siswa]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data gagal disimpan', 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json($siswa);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_absen' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:gurus,id',
            'nama_siswa' => 'required'
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nomor_absen' => $request->nomor_absen,
            'kelas_id' => $request->kelas_id,
            'guru_id' => $request->guru_id,
            'nama_siswa' => $request->nama_siswa
        ]);

        return response()->json(['success' => true, 'data' => $siswa]);
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return response()->json(['success' => true]);
    }

    public function getKelas()
    {
        return response()->json(Kelas::all());
    }
    public function getGuru()
    {
        return response()->json(Guru::all());
    }
}
