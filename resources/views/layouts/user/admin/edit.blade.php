@extends('layouts.templates')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit User</h2>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <select id="role" name="role" class="form-select" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                {{-- <option value="guru" {{ $user->role === 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="murid" {{ $user->role === 'murid' ? 'selected' : '' }}>Murid</option> --}}
            </select>
        </div>

        <button type="submit" class="btn btn-primary me-2">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
