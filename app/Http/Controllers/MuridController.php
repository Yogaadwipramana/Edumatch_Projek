<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Murid;
use App\Models\Guru;
use App\Models\Request as RequestModel; // Alias untuk model Request
use App\Models\Negotiation;

class MuridController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $activeRequests = RequestModel::where('murid_id', $user->murid->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->count();

        return view('layouts.murid.dashboard', compact('activeRequests'));
    }

    public function profile()
    {
        $user = auth()->user();
        $murid = $user->murid;
        return view('layouts.murid.profile', compact('user', 'murid'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bidang_pelatihan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'file_identitas' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->save();

        $murid = $user->murid;

        $data = [
            'bidang_pelatihan' => $request->bidang_pelatihan,
            'lokasi' => $request->lokasi,
        ];

        if ($request->hasFile('file_identitas')) {
            if ($murid->file_identitas) {
                Storage::delete(str_replace('storage/', 'public/', $murid->file_identitas));
            }

            $path = $request->file('file_identitas')->store('public/murid/profile');
            $data['file_identitas'] = str_replace('public/', 'storage/', $path);
        }

        $murid->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function requests()
    {
        $user = auth()->user();
        $requests = RequestModel::with(['guru.user', 'guru'])
            ->where('murid_id', $user->murid->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('layouts.murid.requests.index', compact('requests'));
    }

    public function createRequest($guru_id)
    {
        $guru = Guru::with('user')->findOrFail($guru_id);
        return view('layouts.murid.requests.create', compact('guru'));
    }


    public function storeRequest(Request $request, $guru_id)
    {
        $request->validate([
            'pesan' => 'required|string|max:500',
        ]);

        $murid = auth()->user()->murid;

        RequestModel::create([
            'murid_id' => $murid->id,
            'guru_id' => $guru_id,
            'status' => 'pending',
            'pesan' => $request->pesan,
            'tanggal_request' => now(),
        ]);

        return redirect()->route('murid.requests')
            ->with('success', 'Request berhasil dikirim');
    }

    public function showRequest($id)
    {
        $user = auth()->user();
        $request = RequestModel::with(['guru.user', 'guru', 'negotiations.user'])
            ->where('id', $id)
            ->where('murid_id', $user->murid->id)
            ->firstOrFail();

        return view('layouts.murid.requests.show', compact('request'));
    }


    public function sendNegotiation(Request $request, $id)
    {
        $validated = $request->validate([
            'pesan' => 'required|string',
            'harga' => 'nullable|numeric',
            'waktu_pelaksanaan' => 'nullable|date',
        ]);

        $negotiation = new Negotiation([
            'request_id' => $id,
            'user_id' => auth()->id(),
            'pesan' => $validated['pesan'],
            'harga' => $validated['harga'] ?? null,
            'waktu_pelaksanaan' => $validated['waktu_pelaksanaan'] ?? null,
            'is_from_murid' => true,
        ]);

        $negotiation->save();

        return redirect()->back()->with('success', 'Pesan negosiasi telah dikirim');
    }

    public function completeNegotiation($id)
    {
        $request = RequestModel::findOrFail($id);

        // Validasi bahwa request ini milik murid yang login
        if ($request->murid_id !== auth()->user()->murid->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->status !== 'deal') {
            return redirect()->back()->with('error', 'Hanya request yang sudah deal yang bisa diselesaikan');
        }

        $request->status = 'selesai';
        $request->save();

        return redirect()->back()->with('success', 'Pelatihan telah diselesaikan');
    }
}
