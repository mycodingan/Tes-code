@extends('layout.master')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<h2>Form Guru</h2>
<form id="guruForm" class="form-control">
    @csrf
    <input type="hidden" id="guru_id" name="guru_id">
    
    <label>Nama Guru:</label>
    <input type="text" id="nama_guru" name="nama_guru" required><br><br>

    <label>Kelas:</label>
    <select id="kelas_id" name="kelas_id" required class="form-select"></select><br><br>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<h2>Daftar Guru</h2>
<table border="1" id="guruTable" class="table">
    <thead>
        <tr>
            <th>Nama Guru</th>
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
        $.get('/guru', function(data) {
            let rows = '';
            data.forEach(function(guru) {
                rows += `
                    <tr>
                        <td>${guru.nama_guru}</td>
                        <td>${guru.kelas ? guru.kelas.nama_kelas : '-'}</td>
                        <td>
                            <button onclick="editGuru(${guru.id})" class="btn btn-warning">Edit</button>
                            <button onclick="deleteGuru(${guru.id})" class="btn btn-danger">Hapus</button>
                        </td>
                    </tr>
                `;
            });
            $('#guruTable tbody').html(rows);
        });
    }

    $('#guruForm').submit(function(e) {
        e.preventDefault();

        let guru_id = $('#guru_id').val();
        let url = guru_id ? `/guru/${guru_id}` : '/guru';
        let data = {
            nama_guru: $('#nama_guru').val(),
            kelas_id: $('#kelas_id').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        if (guru_id) {
            data._method = 'PUT';
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                $('#guruForm')[0].reset();
                $('#guru_id').val('');
                loadGuru();
            },
            error: function(xhr) {
                alert('Gagal menyimpan data!');
            }
        });
    });

    function editGuru(id) {
        $.get(`/guru/${id}`, function(data) {
            $('#guru_id').val(data.id);
            $('#nama_guru').val(data.nama_guru);
            $('#kelas_id').val(data.kelas_id);
        });
    }

    function deleteGuru(id) {
        if (confirm('Yakin hapus data ini?')) {
            $.ajax({
                url: `/guru/${id}`,
                method: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    loadGuru();
                },
                error: function(xhr) {
                    alert('Gagal hapus data!');
                }
            });
        }
    }

    $(document).ready(function() {
        loadKelas();
        loadGuru();
    });
</script>

@endsection
