@extends('layouts.templates')

@section('content')
<style>
    .card-guru {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card-guru:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    
    .guru-avatar-container {
        width: 100%;
        height: 200px;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fa;
    }
    
    .guru-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .card-guru:hover .guru-avatar {
        transform: scale(1.05);
    }
    
    .card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .guru-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }
    
    .guru-specialty {
        display: inline-block;
        background-color: #f8f9fa;
        color: #3490dc;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    .guru-location {
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .guru-rating {
        color: #f39c12;
        margin-bottom: 1rem;
    }
    
    .btn-view-profile {
        background-color: #3490dc;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        color: white;
        font-weight: 500;
        margin-top: auto;
        align-self: flex-start;
        transition: all 0.3s;
    }
    
    .btn-view-profile:hover {
        background-color: #2874a6;
        transform: translateY(-2px);
    }
    
    .section-title {
        position: relative;
        margin-bottom: 2rem;
        text-align: center;
        color: #2c3e50;
    }
    
    .section-title:after {
        content: "";
        display: block;
        width: 80px;
        height: 3px;
        background: #3490dc;
        margin: 10px auto;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        background-color: #f8f9fa;
        border-radius: 10px;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    /* Pagination styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .page-item.active .page-link {
        background-color: #3490dc;
        border-color: #3490dc;
    }
    
    .page-link {
        color: #3490dc;
        margin: 0 5px;
        border-radius: 5px;
        padding: 8px 16px;
    }
    
    .page-link:hover {
        color: #2874a6;
        background-color: #f8f9fa;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
    }
    
    .avatar-placeholder i {
        font-size: 4rem;
        color: #6c757d;
    }
</style>

<div class="container py-5">
    <h2 class="section-title">Temukan Guru Terbaik</h2>
    
    @if($gurus->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h4>Belum ada data guru tersedia</h4>
            <p class="text-muted">Silakan coba lagi nanti atau hubungi administrator</p>
        </div>
    @else
        <div class="row">
            @foreach($gurus as $guru)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-guru">
                        <div class="guru-avatar-container">
                            @if($guru->foto_profile && file_exists(public_path('storage/' . $guru->foto_profile)))
                                <img src="{{ asset('storage/' . $guru->foto_profile) }}" 
                                     class="guru-avatar" 
                                     alt="Foto profil {{ $guru->user->name }}"
                                     onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.jpg') }}'">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h5 class="guru-name">{{ $guru->user->name }}</h5>
                            
                            <span class="guru-specialty">
                                <i class="fas fa-certificate me-1"></i> {{ $guru->keahlian }}
                            </span>
                            
                            <div class="guru-location">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $guru->lokasi }}
                            </div>
                            
                            @if($guru->rating)
                                <div class="guru-rating">
                                    <i class="fas fa-star"></i>
                                    {{ number_format($guru->rating, 1) }} 
                                    <small>({{ $guru->jumlah_penilaian }} ulasan)</small>
                                </div>
                            @else
                                <div class="guru-rating text-muted">
                                    <i class="fas fa-star"></i> Belum ada rating
                                </div>
                            @endif
                            
                            <a href="{{ route('guru.show', $guru->id) }}" class="btn btn-view-profile">
                                <i class="fas fa-eye me-1"></i> Lihat Profil
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($gurus instanceof \Illuminate\Pagination\LengthAwarePaginator && $gurus->total() > $gurus->perPage())
            <div class="d-flex justify-content-center mt-4">
                {{ $gurus->links('pagination::bootstrap-4') }}
            </div>
        @endif
    @endif
</div>
@endsection