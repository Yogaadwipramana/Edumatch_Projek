<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\RequestGuru;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    // Halaman dashboard guru
    public function dashboard()
    {
        $pendingRequests = Request::where('status', 'pending')->count(); // Sesuaikan nama field jika perlu

        return view('layouts.guru.dashboard', compact('pendingRequests')); // Pastikan path view sesuai
    }


    // Daftar semua guru (untuk murid)
    public function index()
    {
        $gurus = Guru::with('user')->get();
        return view('layouts.murid.guru.index', compact('gurus'));
    }

    // Detail guru (untuk murid)
    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('layouts.murid.guru.show', compact('guru'));
    }

    // Profile guru (untuk guru)
    public function profile()
    {
        $user = auth()->user();
        $guru = $user->guru;
        return view('layouts.guru.profile', compact('user', 'guru'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'keahlian' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->save();

        $guru = $user->guru;
        $data = [
            'keahlian' => $request->keahlian,
            'lokasi' => $request->lokasi,
        ];

        if ($request->hasFile('foto_profile')) {
            if ($guru->foto_profile) {
                Storage::delete(str_replace('storage/', 'public/', $guru->foto_profile));
            }

            $path = $request->file('foto_profile')->store('public/guru/profile');
            $data['foto_profile'] = str_replace('public/', 'storage/', $path);
        }

        $guru->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}