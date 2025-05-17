@extends('layouts.templates')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Kirim Request ke {{ $guru->user->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('murid.requests.store', $guru->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan Request</label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Request
                            </button>
                            <a href="{{ route('guru.show', $guru->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection