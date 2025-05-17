@extends('layouts.templates')

@section('content')
    <h2>Welcome to Dashboard 🎉</h2>
    <p>You’ve done 72% more sales today. Check your new badge in your profile.</p>
    <button style="margin-top: 10px; padding: 10px 15px; background: #e0e7ff; border: none; color: #4f46e5; border-radius: 5px;">
        View Badges
    </button>

    {{-- Responsive Dashboard Grid --}}
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            margin: 0;
            color: #666;
        }

        .card-value {
            margin: 5px 0 15px;
            font-size: 24px;
        }

        .card-change-up {
            color: green;
            font-size: 14px;
        }

        .card-change-down {
            color: red;
            font-size: 14px;
        }

        .revenue-bars {
            display: flex;
            gap: 4px;
            margin-top: 10px;
        }

        .revenue-bar {
            flex: 1;
            height: 40px;
            border-radius: 4px;
        }
    </style>

    <div class="dashboard-grid">
        {{-- Order Card --}}
        <div class="card">
            <p class="card-title">Order</p>
            <h2 class="card-value">276k</h2>
            <div style="height: 50px; background: linear-gradient(to top, #a3e63533 60%, transparent); border-radius: 5px;"></div>
        </div>

        {{-- Sales Card --}}
        <div class="card">
            <p class="card-title">Sales</p>
            <h2 class="card-value">$4,679</h2>
            <p class="card-change-up">↑ +28.42%</p>
        </div>

        {{-- Payments Card --}}
        <div class="card">
            <p class="card-title">Payments</p>
            <h2 class="card-value">$2,456</h2>
            <p class="card-change-down">↓ -14.82%</p>
        </div>

        {{-- Revenue Card --}}
        <div class="card">
            <p class="card-title">Revenue</p>
            <h2 class="card-value">425k</h2>
            <div class="revenue-bars">
                @foreach(['M','T','W','T','F','S','S'] as $day)
                    <div class="revenue-bar" style="background: {{ $day === 'F' ? '#6366f1' : '#e0e7ff' }};"></div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
