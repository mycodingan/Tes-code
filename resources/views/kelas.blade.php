@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Data Kelas</h4>

    <button class="btn btn-primary mb-3" id="btnTambah">+ Tambah Kelas</button>

    <table class="table table-bordered" id="tabelKelas">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelas as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama_kelas }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $item->id }}">Edit</button>
                        <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modalKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formKelas">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas</label>
                        <input type="text" id="nama_kelas" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('#btnTambah').click(function () {
            $('#formKelas')[0].reset();
            $('#id').val('');
            $('.modal-title').text('Tambah Kelas');
            $('#modalKelas').modal('show');
        });

        $('#formKelas').submit(function (e) {
            e.preventDefault();

            let id = $('#id').val();
            let url = id ? `/kelas` : `/kelas`;
            let method = id ? 'POST' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: {
                    nama_kelas: $('#nama_kelas').val(),
                    id: $('#id').val(),
                    _token: '{{ csrf_token() }}',
                    _method: 'POST'
                },
                success: function () {
                    $('#modalKelas').modal('hide');
                    location.reload();
                }
            });
        });

        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');
            $.get(`/kelas/${id}/edit`, function (res) {
                $('#id').val(res.id);
                $('#nama_kelas').val(res.nama_kelas);
                $('.modal-title').text('Edit Kelas');
                $('#modalKelas').modal('show');
            });
        });
    });
</script>
@endsection
