@extends('layouts.templates')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Detail Request Kerjasama</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nama Guru:</strong>
                </div>
                <div class="col-md-8">
                    {{ $request->guru->user->name }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Keahlian:</strong>
                </div>
                <div class="col-md-8">
                    {{ $request->guru->keahlian }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Tanggal Request:</strong>
                </div>
                <div class="col-md-8">
                    {{ \Carbon\Carbon::parse($request->tanggal_request)->format('d M Y H:i') }}
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Status:</strong>
                </div>
                <div class="col-md-8">
                    @if($request->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($request->status == 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($request->status == 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @elseif($request->status == 'deal')
                        <span class="badge bg-primary">Deal</span>
                    @endif
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Pesan:</strong>
                </div>
                <div class="col-md-8">
                    {{ $request->pesan ?? '-' }}
                </div>
            </div>
            
            @if($request->status == 'disetujui' || $request->status == 'deal')
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Harga:</strong>
                </div>
                <div class="col-md-8">
                    Rp {{ number_format($request->harga, 0, ',', '.') }}
                </div>
            </div>
            @endif
            
            @if($request->negotiations->count() > 0)
            <div class="mt-4">
                <h4>Riwayat Negosiasi</h4>
                @foreach($request->negotiations as $negotiation)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $negotiation->user->name }}</strong>
                            <small>{{ $negotiation->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <p class="mb-1">{{ $negotiation->pesan }}</p>
                        @if($negotiation->harga)
                        <p class="mb-1">Harga: Rp {{ number_format($negotiation->harga, 0, ',', '.') }}</p>
                        @endif
                        @if($negotiation->waktu_pelaksanaan)
                        <p class="mb-0">Waktu: {{ \Carbon\Carbon::parse($negotiation->waktu_pelaksanaan)->format('d M Y') }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            
            <div class="mt-4">
                <a href="{{ route('murid.requests') }}" class="btn btn-secondary">Kembali</a>
                
                @if($request->status == 'disetujui')
                <form action="{{ route('murid.negotiations.send', $request->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Setuju Deal</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection