@extends('superadmin.componen.app')
@section('content')

<div class="card">
    <div class="card-header">Tambah Admin</div>
    <div class="card-body">
        <form action="{{ route('admin_store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Jenis Kelamin</label>
                <select name="jk" class="form-control" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label>No. WA</label>
                <input type="text" name="no_wa" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
@endsection
