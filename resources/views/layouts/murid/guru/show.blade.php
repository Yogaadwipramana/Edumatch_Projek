@extends('layouts.templates')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Request ke Guru {{ $request->guru->user->name }}</h3>
                </div>
                <div class="card-body">
                    <!-- Informasi Guru -->
                    <div class="mb-4">
                        <h4>Informasi Guru</h4>
                        <div class="d-flex align-items-center mb-3">
                            @if($request->guru->user->foto)
                                <img src="{{ asset('storage/' . $request->guru->user->foto) }}" 
                                     alt="{{ $request->guru->user->name }}" 
                                     class="rounded-circle me-3" 
                                     width="80" height="80">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 80px; height: 80px;">
                                    <span class="text-white">{{ substr($request->guru->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $request->guru->user->name }}</h5>
                                <p class="mb-1 text-muted">{{ $request->guru->bidang_keahlian }}</p>
                                <p class="mb-0">
                                    <i class="fas fa-star text-warning"></i>
                                    {{ number_format($request->guru->rating, 1) }} 
                                    ({{ $request->guru->jumlah_penilaian }} ulasan)
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Pendidikan:</strong> {{ $request->guru->pendidikan }}</p>
                                <p><strong>Pengalaman:</strong> {{ $request->guru->pengalaman }} tahun</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Lokasi:</strong> {{ $request->guru->lokasi }}</p>
                                <p><strong>Tarif per jam:</strong> Rp {{ number_format($request->guru->tarif_per_jam, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <p><strong>Deskripsi:</strong> {{ $request->guru->deskripsi }}</p>
                    </div>

                    <hr>

                    <!-- Informasi Request -->
                    <div class="mb-3">
                        <h4>Detail Request</h4>
                        <p><strong>Pesan Request:</strong> {{ $request->pesan }}</p>
                        <p><strong>Tanggal Request:</strong> {{ $request->created_at->translatedFormat('d F Y H:i') }}</p>
                        <p>
                            <strong>Status:</strong>
                            @if($request->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($request->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($request->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($request->status == 'deal')
                                <span class="badge bg-primary">Deal</span>
                            @elseif($request->status == 'selesai')
                                <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </p>
                    </div>
                    
                    <hr>
                    
                    <!-- Negosiasi -->
                    <h4 class="mb-3">Riwayat Negosiasi</h4>
                    
                    @if($request->negotiations->isEmpty())
                        <div class="alert alert-info">
                            Belum ada negosiasi.
                        </div>
                    @else
                        @foreach($request->negotiations as $negotiation)
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $negotiation->user->name }}</strong> - 
                                        <small>{{ $negotiation->created_at->translatedFormat('d M Y H:i') }}</small>
                                    </div>
                                    @if($negotiation->user_id == auth()->id())
                                        <span class="badge bg-info">Anda</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <p>{{ $negotiation->pesan }}</p>
                                    @if($negotiation->harga)
                                        <p><strong>Harga:</strong> Rp {{ number_format($negotiation->harga, 0, ',', '.') }}</p>
                                    @endif
                                    @if($negotiation->waktu_pelaksanaan)
                                        <p><strong>Waktu Pelaksanaan:</strong> {{ \Carbon\Carbon::parse($negotiation->waktu_pelaksanaan)->translatedFormat('d F Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                    <!-- Form Negosiasi -->
                    @if($request->status == 'disetujui' || $request->status == 'deal')
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5>Kirim Negosiasi</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('murid.negotiations.send', $request->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="pesan" class="form-label">Pesan *</label>
                                        <textarea class="form-control" id="pesan" name="pesan" rows="3" required placeholder="Tulis pesan negosiasi Anda"></textarea>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="harga" class="form-label">Harga (Rp)</label>
                                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Contoh: 500000">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="waktu_pelaksanaan" class="form-label">Waktu Pelaksanaan</label>
                                            <input type="datetime-local" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-1"></i> Kirim
                                    </button>
                                    
                                    @if($request->status == 'deal' && auth()->user()->role == 'murid')
                                        <button type="button" class="btn btn-success ms-2" onclick="event.preventDefault(); document.getElementById('complete-form').submit();">
                                            <i class="fas fa-check-circle me-1"></i> Tandai Selesai
                                        </button>
                                    @endif
                                </form>
                                
                                @if($request->status == 'deal' && auth()->user()->role == 'murid')
                                    <form id="complete-form" action="{{ route('murid.negotiations.complete', $request->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Sidebar dengan info tambahan -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Detail Request</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Status</span>
                            @if($request->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($request->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($request->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($request->status == 'deal')
                                <span class="badge bg-primary">Deal</span>
                            @elseif($request->status == 'selesai')
                                <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Tanggal Request</span>
                            <span>{{ $request->created_at->translatedFormat('d M Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Jumlah Negosiasi</span>
                            <span>{{ $request->negotiations->count() }}</span>
                        </li>
                        @if($request->status == 'deal')
                            <li class="list-group-item bg-light">
                                <strong>Deal pada:</strong> 
                                {{ $request->updated_at->translatedFormat('d F Y H:i') }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            @if($request->status == 'deal')
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Info Deal</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $lastNegotiation = $request->negotiations->sortByDesc('created_at')->first();
                        @endphp
                        
                        @if($lastNegotiation)
                            @if($lastNegotiation->harga)
                                <p><strong>Harga Deal:</strong> Rp {{ number_format($lastNegotiation->harga, 0, ',', '.') }}</p>
                            @endif
                            
                            @if($lastNegotiation->waktu_pelaksanaan)
                                <p><strong>Waktu Pelaksanaan:</strong> {{ \Carbon\Carbon::parse($lastNegotiation->waktu_pelaksanaan)->translatedFormat('d F Y H:i') }}</p>
                            @endif
                            
                            <hr>
                            <p class="text-muted">Pastikan Anda hadir sesuai waktu yang telah disepakati.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection