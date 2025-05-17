@extends('layouts.templates')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .page-title {
        text-align: center;
        font-weight: bold;
        font-size: 28px;
        color: #2c3e50;
        margin-bottom: 30px;
    }

    .card-profile {
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        border-radius: 0;
        padding: 20px;
    }

    .img-preview {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        margin-bottom: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .form-label {
        font-weight: 500;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .invalid-feedback {
        font-size: 0.875rem;
    }

    @media(max-width: 767px) {
        .img-preview {
            width: 150px;
            height: 150px;
        }
    }
</style>

<div class="container py-5">
    <h2 class="page-title">Update Profile Guru</h2>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-profile">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Formulir Perubahan Data</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('guru.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row align-items-start">
                            <!-- Foto Profil -->
                            <div class="col-md-4 text-center">
                                @if($guru->foto_profile)
                                    <img src="{{ asset($guru->foto_profile) }}" alt="Foto Guru" id="previewFoto" class="img-preview">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200" alt="Avatar" id="previewFoto" class="img-preview">
                                @endif

                                <div class="mt-3 text-start">
                                    <label for="foto_profile" class="form-label">Ubah Foto Profil</label>
                                    <input type="file" class="form-control @error('foto_profile') is-invalid @enderror" id="foto_profile" name="foto_profile" onchange="previewImage(this)">
                                    @error('foto_profile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: JPG/PNG, Maks: 2MB</small>
                                </div>
                            </div>

                            <!-- Formulir Data -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                    <small class="text-muted">Email tidak dapat diubah</small>
                                </div>

                                <div class="mb-3">
                                    <label for="keahlian" class="form-label">Bidang Keahlian</label>
                                    <input type="text" class="form-control @error('keahlian') is-invalid @enderror" id="keahlian" name="keahlian" value="{{ old('keahlian', $guru->keahlian) }}" required>
                                    @error('keahlian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $guru->lokasi) }}" required>
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-4 d-flex justify-content-end">
                                    <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('previewFoto');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
