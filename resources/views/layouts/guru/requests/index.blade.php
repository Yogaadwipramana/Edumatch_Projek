@extends('layouts.templates')

@section('content')
<!-- Optional Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .page-title {
        font-size: 28px;
        font-weight: bold;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 30px;
    }

    .table thead {
        background-color: #343a40;
        color: #fff;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.875rem;
        padding: 0.5em 0.75em;
    }

    .btn-info {
        background-color: #17a2b8;
        border: none;
    }

    .btn-info:hover {
        background-color: #138496;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }

    .card-custom {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 20px;
    }
</style>

<div class="container py-4">
    <h2 class="page-title">Request Masuk</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-custom">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Murid</th>
                        <th>Pesan</th>
                        <th>Tanggal Request</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td>{{ $req->murid->user->name }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($req->pesan, 50) }}</td>
                        <td>{{ $req->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if($req->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($req->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($req->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($req->status == 'deal')
                                <span class="badge bg-primary">Deal</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('guru.requests.show', $req->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada request masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
