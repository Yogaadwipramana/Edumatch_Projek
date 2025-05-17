@extends('layouts.templates')

@section('content')
<div class="container">
    <h2>Request Kerjasama Saya</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Guru</th>
                    <th>Keahlian</th>
                    <th>Tanggal Request</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td>{{ $req->guru->user->name ?? 'N/A' }}</td>
                    <td>{{ $req->guru->keahlian ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($req->tanggal_request)->format('d M Y H:i') }}</td>
                    <td>
                        @if($req->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($req->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($req->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($req->status == 'deal')
                            <span class="badge bg-primary">Deal</span>
                        @else
                            <span class="badge bg-secondary">{{ $req->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('murid.requests.show', $req->id) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada request kerjasama</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($requests->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection