@extends('layouts.templates')

@section('content')
<style>
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 25px;
        text-align: center;
    }

    .card-header strong {
        font-weight: 600;
        color: #34495e;
    }

    .card-header small {
        color: #7f8c8d;
        font-style: italic;
    }

    .negotiation-card {
        border-left: 4px solid #0d6efd;
        box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
    }

    .btn-deal {
        background-color: #198754;
        border-color: #198754;
    }

    .btn-deal:hover {
        background-color: #157347;
        border-color: #146c43;
    }
</style>

<div class="container py-4">
    <h2 class="page-title">Request dari {{ $request->murid->user->name }}</h2>

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Request</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-secondary fw-bold">Pesan Request:</h6>
                        <p class="fs-5">{{ $request->pesan }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-secondary fw-bold">Status:</h6>
                        @if($request->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($request->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($request->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($request->status == 'deal')
                            <span class="badge bg-primary">Deal</span>
                        @endif
                    </div>

                    @if($request->status == 'pending')
                        <div class="d-flex gap-3 mb-4">
                            <form action="{{ route('guru.requests.accept', $request->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-2"></i> Terima Request
                                </button>
                            </form>
                            <form action="{{ route('guru.requests.reject', $request->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-times me-2"></i> Tolak Request
                                </button>
                            </form>
                        </div>
                    @endif

                    <hr>

                    <h4 class="mb-4 text-primary">Negosiasi</h4>

                    @forelse($request->negotiations as $negotiation)
                        <div class="card mb-3 negotiation-card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <strong>{{ $negotiation->user->name }}</strong>
                                <small>{{ \Carbon\Carbon::parse($negotiation->created_at)->format('d M Y H:i') }}</small>
                            </div>
                            <div class="card-body">
                                <p>{{ $negotiation->pesan }}</p>
                                @if($negotiation->harga)
                                    <p><strong>Harga:</strong> Rp {{ number_format($negotiation->harga, 0, ',', '.') }}</p>
                                @endif
                                @if($negotiation->waktu_pelaksanaan)
                                    <p><strong>Waktu Pelaksanaan:</strong> {{ \Carbon\Carbon::parse($negotiation->waktu_pelaksanaan)->format('d M Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted fst-italic">Belum ada negosiasi.</p>
                    @endforelse

                    @if($request->status == 'disetujui' || $request->status == 'deal')
                        <form action="{{ route('guru.negotiations.send', $request->id) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan Negosiasi</label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="3" required></textarea>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="harga" class="form-label">Harga (Rp)</label>
                                    <input type="number" class="form-control" id="harga" name="harga" min="0" placeholder="Contoh: 100000">
                                </div>
                                <div class="col-md-6">
                                    <label for="waktu_pelaksanaan" class="form-label">Waktu Pelaksanaan</label>
                                    <input type="datetime-local" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan">
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary me-3">
                                    <i class="fas fa-paper-plane me-1"></i> Kirim
                                </button>

                                @if($request->status == 'disetujui' && auth()->user()->role == 'guru')
                                    <button type="button" class="btn btn-deal" onclick="event.preventDefault(); document.getElementById('deal-form').submit();">
                                        <i class="fas fa-handshake"></i> Deal
                                    </button>
                                @endif
                            </div>
                        </form>

                        @if($request->status == 'disetujui' && auth()->user()->role == 'guru')
                            <form id="deal-form" action="{{ route('guru.negotiations.deal', $request->id) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Load FontAwesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
