@extends('layouts.templates')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Update Profile Murid</h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('murid.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri - Foto Profil -->
                            <div class="col-md-4 text-center">
                                <div class="mb-3">
                                    @if($murid->file_identitas)
                                        <img src="{{ asset($murid->file_identitas) }}" class="img-thumbnail rounded-circle" style="width: 200px; height: 200px; object-fit: cover;" id="previewFoto">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200" class="img-thumbnail rounded-circle" style="width: 200px; height: 200px; object-fit: cover;" id="previewFoto">
                                    @endif
                                </div>
                                
                                <div class="mb-3">
                                    <label for="file_identitas" class="form-label">Ubah Foto Profil</label>
                                    <input type="file" class="form-control @error('file_identitas') is-invalid @enderror" id="file_identitas" name="file_identitas" onchange="previewImage(this)">
                                    @error('file_identitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: JPG/PNG, Maks: 2MB</small>
                                </div>
                            </div>

                            <!-- Kolom Kanan - Biodata -->
                            <div class="col-md-8">
                                <div class="mb-3 row">
                                    <label for="name" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                        <small class="text-muted">Email tidak dapat diubah</small>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="bidang_pelatihan" class="col-sm-3 col-form-label">Bidang Keahlian</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('bidang_pelatihan') is-invalid @enderror" id="bidang_pelatihan" name="bidang_pelatihan" value="{{ old('bidang_pelatihan', $murid->bidang_pelatihan) }}" required>
                                        @error('bidang_pelatihan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="lokasi" class="col-sm-3 col-form-label">Lokasi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $murid->lokasi) }}" required>
                                        @error('lokasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                                        </button>
                                        <a href="{{ route('murid.dashboard') }}" class="btn btn-outline-secondary ms-2">
                                            <i class="fas fa-arrow-left me-2"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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

<style>
    .form-label {
        font-weight: 500;
    }
    .img-thumbnail {
        border: 3px solid #dee2e6;
    }
</style>
@endsection
