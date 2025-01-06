@extends('layouts.main')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Data Pengguna</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables </h6>
            </div>
            <div>
                <a class="btn btn-sm btn-primary mt-2 ml-4" id="add_penguna">
                    Tambah
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>no</th>
                                <th>id barang</th>
                                <th>nama</th>
                                <th>Email</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                            Edit Pengguna
                                        </a>
                                        <a class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                            Delete Pengguna
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pengguna -->
        <div class="modal fade" id="modalTambahPengguna" tabindex="-1" aria-labelledby="modalTambahPenggunaLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPenggunaLabel">Tambah Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formTambahPengguna">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            // Tampilkan modal saat tombol Tambah diklik
            $('#add_penguna').on('click', function() {
                $('#modalTambahPengguna').modal('show');
            });

            // Submit form menggunakan AJAX
            $('#formTambahPengguna').on('submit', function(e) {
                e.preventDefault();

                // Ambil data dari form
                const data = {
                    nama: $('#nama').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                };

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: 'pengguna/add',
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Pastikan CSRF token ada di head
                    },
                    success: function(response) {
                        // Tampilkan pesan sukses
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message || 'Pengguna berhasil ditambahkan!',
                            icon: 'success',
                        });

                        // Tutup modal dan reset form
                        $('#modalTambahPengguna').modal('hide');
                        $('#formTambahPengguna')[0].reset();
                        window.location.reload();
                    },
                    error: function(xhr) {
                        // Tampilkan pesan error
                        Swal.fire({
                            title: 'Gagal',
                            text: xhr.responseJSON.message ||
                                'Terjadi kesalahan saat menambahkan pengguna!',
                            icon: 'error',
                        });
                    },
                });
            });
        });
    </script>

    <!-- /.container-fluid -->
@endsection
