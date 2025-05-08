<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $gurus = Guru::with('kelas')->get();
            return response()->json($gurus);
        }

        return view('guru');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        try {
            $guru = Guru::create([
                'nama_guru' => $request->nama_guru,
                'kelas_id' => $request->kelas_id,
            ]);
            return response()->json(['success' => true, 'data' => $guru]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data gagal disimpan', 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        return response()->json($guru);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_guru' => 'required',
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

        return response()->json(['success' => true]);
    }

    public function getKelas()
    {
        return response()->json(Kelas::all());
    }
}
