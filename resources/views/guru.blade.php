@extends('layout.master')
@section('content')
<!-- Form Input Guru -->
<form id="guruForm">
    <label for="nama_guru">Nama Guru:</label>
    <input type="text" id="nama_guru" name="nama_guru" required>

    <label for="kelas_id">Kelas:</label>
    <select id="kelas_id" name="kelas_id" required>
    </select>

    <button type="submit">Tambah Guru</button>
</form>

<table id="guruTable">
    <thead>
        <tr>
            <th>Nama Guru</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function fetchGurus() {
        $.ajax({
            url: '/guru',
            method: 'GET',
            success: function(data) {
                let guruRows = '';
                data.forEach(guru => {
                    guruRows += `
                        <tr>
                            <td>${guru.nama_guru}</td>
                            <td>${guru.kelas.nama_kelas}</td>
                            <td>
                                <button class="edit" data-id="${guru.id}">Edit</button>
                                <button class="delete" data-id="${guru.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $('#guruTable tbody').html(guruRows);
            }
        });
    }

    function fetchKelas() {
        $.ajax({
            url: '/kelas',
            method: 'GET',
            success: function(data) {
                let kelasOptions = '';
                data.forEach(kelas => {
                    kelasOptions += `<option value="${kelas.id}">${kelas.nama_kelas}</option>`;
                });
                $('#kelas_id').html(kelasOptions);
            }
        });
    }

    fetchKelas();

    $('#guruForm').on('submit', function(e) {
        e.preventDefault();
        const namaGuru = $('#nama_guru').val();
        const kelasId = $('#kelas_id').val();

        $.ajax({
            url: '/guru',
            method: 'POST',
            data: { nama_guru: namaGuru, kelas_id: kelasId },
            success: function(response) {
                fetchGurus(); 
                $('#guruForm')[0].reset(); 
            }
        });
    });

    $(document).on('click', '.edit', function() {
        const guruId = $(this).data('id');
        $.ajax({
            url: `/guru/${guruId}`,
            method: 'GET',
            success: function(data) {
                $('#nama_guru').val(data.nama_guru);
                $('#kelas_id').val(data.kelas_id);
         
                $('#guruForm').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: `/guru/${guruId}`,
                        method: 'PUT',
                        data: {
                            nama_guru: $('#nama_guru').val(),
                            kelas_id: $('#kelas_id').val()
                        },
                        success: function(response) {
                            fetchGurus(); 
                        }
                    });
                });
            }
        });
    });

    $(document).on('click', '.delete', function() {
        const guruId = $(this).data('id');
        if (confirm('Are you sure you want to delete this guru?')) {
            $.ajax({
                url: `/guru/${guruId}`,
                method: 'DELETE',
                success: function(response) {
                    fetchGurus();
                }
            });
        }
    });

    fetchGurus();
});
</script>

@endsection