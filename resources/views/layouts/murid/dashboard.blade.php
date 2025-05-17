@extends('layouts.templates')

@section('content')
<!-- Tambahkan ini di <head> layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .dashboard-title {
        margin: 40px 0 20px;
        font-weight: 700;
        color: #2c3e50;
        text-align: center;
    }

    .card-dashboard {
        max-width: 400px;
        margin: 0 auto;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
        border: none;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .card-dashboard:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 30px;
        text-align: center;
    }

    .card-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .card-text.display-4 {
        font-size: 2.8rem;
        font-weight: 800;
    }

    .detail-link {
        margin-top: 20px;
        display: inline-block;
        font-weight: 500;
        color: #ffffff;
        text-decoration: underline;
    }

    .detail-link:hover {
        color: #dcdde1;
        text-decoration: none;
    }
</style>

<div class="container">
    <h2 class="dashboard-title">Dashboard Murid</h2>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card card-dashboard bg-primary text-white">
                <div class="card-body">
                    <i class="fas fa-tasks fa-2x mb-3"></i>
                    <h5 class="card-title">Request Aktif</h5>
<!--                     <p class="card-text display-4">{{ $activeRequests }}</p> -->
                    <a href="{{ route('murid.requests') }}" class="detail-link">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
