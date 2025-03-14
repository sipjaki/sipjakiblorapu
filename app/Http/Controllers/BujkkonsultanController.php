<?php

namespace App\Http\Controllers;

use App\Models\bujkkonsultan;
use App\Models\bujkkonsultansub;
use App\Models\bujkkontraktor;
use App\Models\bujkkontraktorsub;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;



class BujkkonsultanController extends Controller
{
    //
    // public function bujkkonsultan(Request $request)
    // {

    //     $perPage = $request->input('perPage', 200); // Ambil jumlah data dari request, default 10
    //     $data = bujkkonsultan::paginate($perPage);
    //     $datasub = bujkkonsultansub::all();
    //     $user = Auth::user();

    //     return view('frontend.03_masjaki_jakon.02_bujkkonsultan.bujkkonsultan', [
    //         'title' => 'BUJK Konstruksi',
    //         'user' => $user,
    //         'data' => $data,
    //         'datasub' => $datasub,
    //         'perPage' => $perPage // Kirim nilai perPage ke view
    //     ]);


    // }


    public function bujkkonsultan(Request $request)
{
    $perPage = $request->input('perPage', 10);
    $search = $request->input('search');

    $query = bujkkonsultan::query();

    if ($search) {
        $query->where('namalengkap', 'LIKE', "%{$search}%")
              ->orWhere('alamat', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('nib', 'LIKE', "%{$search}%");
    }

    $data = $query->paginate($perPage);

    if ($request->ajax()) {
        return response()->json([
            'html' => view('frontend.03_masjaki_jakon.02_bujkkonsultan.partials.table', compact('data'))->render()
        ]);
    }

    return view('frontend.03_masjaki_jakon.02_bujkkonsultan.bujkkonsultan', [
        'title' => 'BUJK Konsultasi Konstruksi',
        'data' => $data,
        'perPage' => $perPage,
        'search' => $search
    ]);
}

    public function bujkkonsultanshow($namalengkap)
    {
        $databujkkonsultan = bujkkonsultan::where('namalengkap', $namalengkap)->first();

        if (!$databujkkonsultan) {
            // Tangani jika kegiatan tidak ditemukan
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan.');
        }

        // Menggunakan paginate() untuk pagination
        $subdata = bujkkonsultansub::where('bujkkonsultan_id', $databujkkonsultan->id)->paginate(10);

          // Menghitung nomor urut mulai
            $start = ($subdata->currentPage() - 1) * $subdata->perPage() + 1;


    // Ambil data user saat ini
    $user = Auth::user();

    return view('frontend.03_masjaki_jakon.02_bujkkonsultan.bujkkonsultanshow', [
        'title' => 'Data Bujk Konstruksi Konsultasi',
        'data' => $databujkkonsultan,
        'subData' => $subdata,  // Jika Anda ingin mengirimkan data sub kontraktor juga
        'user' => $user,
        'start' => $start,
    ]);
    }


}
