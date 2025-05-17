@extends('layouts.templates')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tambah User</h2>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" id="name" name="name" class="form-control" required autofocus value="{{ old('name') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <select id="role" name="role" class="form-select" required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                {{-- <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="murid" {{ old('role') == 'murid' ? 'selected' : '' }}>Murid</option> --}}
            </select>
            @error('role')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success me-2">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
