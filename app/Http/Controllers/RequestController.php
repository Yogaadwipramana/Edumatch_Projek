<?php

namespace App\Http\Controllers;

use App\Models\Request as Req;
use App\Models\Murid;
use App\Models\Guru;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Request;

class RequestController extends Controller
{
public function sendRequest($guru_id)
{
    $request = new Request();
    $request->murid_id = auth()->user()->murid->id;
    $request->guru_id = $guru_id;
    $request->status = 'pending';
    $request->tanggal_request = now();
    $request->save();

    return redirect()->back()->with('success', 'Request dikirim');
}

public function guruRequests()
{
    $requests = Request::where('guru_id', auth()->user()->guru->id)->with('murid.user')->get();
    return view('layouts.guru.guru_request', compact('requests'));
}

public function setStatus($id, $status)
{
    $request = Request::findOrFail($id);

    if ($status == 'disetujui') {
        $request->status = 'disetujui';
    } elseif ($status == 'ditolak') {
        $request->status = 'ditolak';
    }
    $request->save();

    return back()->with('success', 'Status diperbarui');
}

public function markAsDeal($id)
{
    $request = Request::findOrFail($id);
    $request->status = 'deal';
    $request->tanggal_deal = now();
    $request->save();

    return back()->with('success', 'Kerjasama disetujui');
}

  public function show($id)
    {
        // Ambil data request beserta relasi guru dan user guru
        $request = Request::with(['guru.user', 'negotiations.user'])
            ->findOrFail($id);
            
        // Pastikan hanya murid yang membuat request atau guru yang dituju yang bisa melihat
        if (auth()->user()->role == 'murid' && $request->murid_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        if (auth()->user()->role == 'guru' && $request->guru_id != auth()->user()->guru->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('requests.show', compact('request'));
    }

}

