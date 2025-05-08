@extends('layout.master')

@section('content')
<div class="container">
    <ul class="nav nav-tabs" id="dasTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="siswa-tab" data-bs-toggle="tab" href="#siswa" role="tab">Siswa per Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="guru-tab" data-bs-toggle="tab" href="#guru" role="tab">Guru per Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="full-tab" data-bs-toggle="tab" href="#full" role="tab">Siswa + Kelas + Guru</a>
        </li>
    </ul>
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="siswa" role="tabpanel">
            @foreach($kelasWithSiswa as $kelas)
                <h5>{{ $kelas->nama_kelas }}</h5>
                <ul>
                    @foreach($kelas->siswa as $siswa)
                        <li>{{ $siswa->nama_siswa }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
        <div class="tab-pane fade" id="guru" role="tabpanel">
            @foreach($kelasWithGuru as $kelas)
                <h5>{{ $kelas->nama_kelas }}</h5>
                <ul>
                    @foreach($kelas->guru as $guru)
                        <li>{{ $guru->nama_guru }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
        <div class="tab-pane fade" id="full" role="tabpanel">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaFull as $siswa)
                        <tr>
                            <td>{{ $siswa->nama_siswa }}</td>
                            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $siswa->guru->nama_guru ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
