@extends('layouts.main')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Data Order</h1>

        <!-- DataTables Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Order</h6>
            </div>
            <div class="d-flex justify-content-between align-content-center">
                <button class="btn btn-sm btn-secondary mt-2 ml-4" id="export_pdf">Export PDF</button>
                <button class="btn btn-sm btn-primary mt-2 mr-4" id="tambah_order">Add New Order</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Order</th>
                                <th>Tamu</th>
                                <th>Tipe Kamar</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->id_pesanan }}</td>
                                    <td>{{ $order->nama_tamu }}</td>
                                    <td>{{ $order->tipe_kamar }}</td>
                                    <td>{{ $order->check_in }}</td>
                                    <td>{{ $order->check_out }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-warning edit_order" data-id="{{ $order->id_pesanan }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger hapus_buku"
                                            data-id="{{ $order->id_pesanan }}">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Buku -->
        <div class="modal fade" id="modalTambahorder" tabindex="-1" aria-labelledby="modalTambahorderLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahorderLabel">New Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formTambahorder">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_tamu">Nama Tamu</label>
                                <input type="text" class="form-control" id="nama_tamu" name="nama_tamu" required>
                            </div>
                            <div class="form-group">
                                <label for="tipe_kamar">Tipe Kamar</label>
                                <select class="form-control" id="tipe_kamar" name="tipe_kamar" required>
                                    <option value="">Pilih Tipe Kamar</option>
                                    <option value="single">Single</option>
                                    <option value="double">Double</option>
                                    <option value="king">King</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="check_in">Check-in</label>
                                <input type="datetime-local" class="form-control" id="check_in" name="check_in" required>
                            </div>
                            <div class="form-group">
                                <label for="check_out">Check-out</label>
                                <input type="datetime-local" class="form-control" id="check_out" name="check_out" required>
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
        <div class="modal fade" id="modalEditorder" tabindex="-1" aria-labelledby="modalEditorderLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditorderLabel">Edit Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formEditorder">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Editnama_tamu">Nama Tamu</label>
                                <input type="text" name="id_buku" id="id_buku" hidden>
                                <input type="text" class="form-control" id="Editnama_tamu" name="Editnama_tamu" required>
                            </div>
                            <div class="form-group">
                                <label for="Edittipe_kamar">Tipe Kamar</label>
                                <select class="form-control" id="Edittipe_kamar" name="Edittipe_kamar" required>
                                    <option value="">Pilih Tipe Kamar</option>
                                    <option value="single">Single</option>
                                    <option value="double">Double</option>
                                    <option value="king">King</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Editcheck_in">Check-in</label>
                                <input type="datetime-local" class="form-control" id="Editcheck_in" name="Editcheck_in"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="Editcheck_out">Check-out</label>
                                <input type="datetime-local" class="form-control" id="Editcheck_out"
                                    name="Editcheck_out" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Perbaharui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#export_pdf').on('click', function() {
                $.ajax({
                    url: '/export-pdf',
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Download file PDF
                            let link = document.createElement('a');
                            link.href = response.url; 
                            link.download = 'order.pdf';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan pada server.');
                    }
                });
            });
            $('#tambah_order').on('click', function() {
                $('#modalTambahorder').modal('show');
            });

            $('.hapus_buku').on('click', function() {
                var id_order = $(this).data('id');
                Swal.fire({
                    title: 'Yakin?',
                    text: 'Apakah Anda yakin ingin menghapus Order ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'order/delete/' + id_order,
                            method: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Berhasil',
                                        text: response.message ||
                                            'berhasil Menghapus Order!',
                                        icon: 'success',
                                    });
                                    location.reload();
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan saat Menghapus Order!',
                                    icon: 'error',
                                });
                            },
                        });
                    }
                });
            });

            $('.edit_order').on('click', function() {
                var id_order = $(this).data('id');
                $.ajax({
                    url: 'order/' + id_order,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#modalEditorder').modal('show');
                            $('#id_buku').val(response.data.id_pesanan);
                            $('#Editnama_tamu').val(response.data.nama_tamu);
                            $('#Edittipe_kamar').val(response.data.tipe_kamar);
                            $('#Editcheck_in').val(response.data.check_in);
                            $('#Editcheck_out').val(response.data.check_out);
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal',
                            text: xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat mengambil data pesanan!',
                            icon: 'error',
                        });
                    },
                });
            });

            // Kirim form menggunakan AJAX
            $('#formTambahorder').on('submit', function(e) {
                e.preventDefault();

                // Ambil data dari form
                const data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    nama_tamu: $('#nama_tamu').val(),
                    tipe_kamar: $('#tipe_kamar').val(),
                    check_in: $('#check_in').val(),
                    check_out: $('#check_out').val(),
                };

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: 'order/add',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message || 'Buku berhasil ditambahkan!',
                            icon: 'success',
                        });

                        // Tutup modal dan reset form
                        $('#modalTambahorder').modal('hide');
                        $('#formTambahorder')[0].reset();
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal',
                            text: xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat menambahkan buku!',
                            icon: 'error',
                        });
                    },
                });
            });
            $('#formEditorder').on('submit', function(e) {
                e.preventDefault();

                // Ambil data dari form
                const data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id_pesanan: $('#id_buku').val(),
                    nama_tamu: $('#Editnama_tamu').val(),
                    tipe_kamar: $('#Edittipe_kamar').val(),
                    check_in: $('#Editcheck_in').val(),
                    check_out: $('#Editcheck_out').val(),
                };

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: 'order/update',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message || 'Pesanan berhasil diperbaharui!',
                            icon: 'success',
                        });

                        $('#modalEditorder').modal('hide');
                        $('#formEditorder')[0].reset();
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal',
                            text: xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat memperbaharui pesanan!',
                            icon: 'error',
                        });
                    },
                });
            });
        });
    </script>
@endsection
