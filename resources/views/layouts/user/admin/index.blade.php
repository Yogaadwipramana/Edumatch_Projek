@extends('layouts.templates')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* Hover efek untuk baris tabel */
    tbody tr:hover {
        background-color: #f1f5fb;
        transition: background-color 0.3s ease;
    }

    /* Garis pemisah antar baris */
    tbody tr {
        border-bottom: 1px solid #dee2e6;
    }

    /* Padding sel tabel lebih nyaman */
    th, td {
        vertical-align: middle;
        padding: 0.75rem 1rem;
    }

    /* Header tabel bold, uppercase dan garis bawah tegas */
    thead th {
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #0d6efd;
    }

    /* Tombol aksi ukuran kecil dengan padding nyaman */
    .btn-sm {
        padding: 0.35rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }

    /* Hover efek tombol Edit */
    .btn-warning:hover {
        background-color: #ffc107cc;
        border-color: #ffc107cc;
        color: #212529;
    }

    /* Hover efek tombol Hapus */
    .btn-danger:hover {
        background-color: #dc3545cc;
        border-color: #dc3545cc;
        color: #fff;
    }

    /* Badge role lebih menonjol */
    .badge {
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.35em 0.7em;
    }

    /* Shadow lembut di container tabel */
    .table-responsive {
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 0.1);
        border-radius: 0.375rem;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Data User</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center" style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td class="fw-semibold">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            <span class="badge bg-info text-dark text-capitalize">{{ $u->role }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-warning me-2" title="Edit User">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('users.destroy', $u->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit" title="Hapus User">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted fst-italic">Tidak ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
