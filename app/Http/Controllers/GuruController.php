<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all(); 
        return view('guru', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $guru = Guru::create([
            'nama_guru' => $request->nama_guru,
            'kelas_id' => $request->kelas_id,
        ]);

        return response()->json(['success' => true, 'data' => $guru]);
    }

    public function show($id)
    {
        $guru = Guru::with('kelas')->findOrFail($id);
        return response()->json($guru);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $guru = Guru::findOrFail($id);
        $guru->update([
            'nama_guru' => $request->nama_guru,
            'kelas_id' => $request->kelas_id,
        ]);

        return response()->json(['success' => true, 'data' => $guru]);
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return response()->json(['success' => true, 'message' => 'Guru deleted successfully']);
    }

    public function getKelas()
    {
        $kelas = Kelas::all();
        return response()->json($kelas);
    }
}
