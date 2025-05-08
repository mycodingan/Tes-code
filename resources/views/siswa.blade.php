@extends('layout.master')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<h2>Form Siswa</h2>
<form id="siswaForm" class="form-control">
    @csrf
    <input type="hidden" id="siswa_id" name="siswa_id">

    <label>Nomor Absen:</label>
    <input type="text" id="nomor_absen" name="nomor_absen" required><br><br>

    <label>Nama Siswa:</label>
    <input type="text" id="nama_siswa" name="nama_siswa" required><br><br>

    <label>Guru:</label>
    <select id="guru_id" name="guru_id" required class="form-select"></select>

    <label>Kelas:</label>
    <select id="kelas_id" name="kelas_id" required class="form-select"></select><br><br>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<h2>Daftar Siswa</h2>
<table border="1" id="siswaTable" class="table">
    <thead>
        <tr>
            <th>Nomor Absen</th>
            <th>Nama Siswa</th>
            <th>Guru</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadKelas() {
        $.get('/kelassss', function(data) {
            $('#kelas_id').html('');
            data.forEach(function(kelas) {
                $('#kelas_id').append(`<option value="${kelas.id}">${kelas.nama_kelas}</option>`);
            });
        });
    }

    function loadGuru() {
    $.get('/gurusss', function(data) {
        $('#guru_id').html('');
        data.forEach(function(guru) {
            $('#guru_id').append(`<option value="${guru.id}">${guru.nama_guru}</option>`);
        });
    });
}


    function loadSiswa() {
        $.get('/siswa/data', function(data) {
            let rows = '';
            data.forEach(function(siswa) {
                rows += `
                    <tr>
                        <td>${siswa.nomor_absen}</td>
                        <td>${siswa.nama_siswa}</td>
                        <td>${siswa.guru ? siswa.guru.nama_guru : '-'}</td>
                        <td>${siswa.kelas ? siswa.kelas.nama_kelas : '-'}</td>
                        <td>
                            <button onclick="editSiswa(${siswa.id})" class="btn btn-warning">Edit</button>
                            <button onclick="deleteSiswa(${siswa.id})" class="btn btn-danger">Hapus</button>
                        </td>
                    </tr>
                `;
            });
            $('#siswaTable tbody').html(rows);
        });
    }

    $('#siswaForm').submit(function(e) {
        e.preventDefault();

        let siswa_id = $('#siswa_id').val();
        let url = siswa_id ? `/siswa/update/${siswa_id}` : '/siswa/store';
        let data = {
            nomor_absen: $('#nomor_absen').val(),
            nama_siswa: $('#nama_siswa').val(),
            guru_id: $('#guru_id').val(),
            kelas_id: $('#kelas_id').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        if (siswa_id) {
            data._method = 'POST';
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                $('#siswaForm')[0].reset();
                $('#siswa_id').val('');
                loadSiswa();
            },
            error: function(xhr) {
                alert('Gagal menyimpan data!');
            }
        });
    });

    function editSiswa(id) {
        $.get(`/siswa/data/${id}`, function(data) {
            $('#siswa_id').val(data.id);
            $('#nomor_absen').val(data.nomor_absen);
            $('#nama_siswa').val(data.nama_siswa);
            $('#guru_id').val(data.guru_id);
            $('#kelas_id').val(data.kelas_id);
        });
    }

    function deleteSiswa(id) {
        if (confirm('Yakin hapus data ini?')) {
            $.ajax({
                url: `/siswa/delete/${id}`,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    loadSiswa();
                },
                error: function() {
                    alert('Gagal menghapus data!');
                }
            });
        }
    }

    $(document).ready(function() {
        loadKelas();
        loadGuru();
        loadSiswa();
    });
</script>

@endsection
