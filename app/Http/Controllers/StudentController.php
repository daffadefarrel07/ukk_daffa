<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $siswa = $user->siswa;
        if (! $siswa) {
            return redirect('/')->with('error', 'Siswa tidak ditemukan atau belum dikaitkan dengan akun Anda.');
        }

        $inputs = $siswa->inputAspirasis()->with('kategori')->get();

        $items = [];
        $statusMap = ['Menunggu' => 0, 'Proses' => 50, 'Selesai' => 100];
        $progressSum = 0;
        $feedbackList = [];
        foreach ($inputs as $input) {
            $asp = Aspirasi::where('kategori_id', $input->kategori_id)->latest()->first();
            $status = $asp?->status ?? 'Menunggu';
            $feedback = $asp?->feedback;

            $items[] = [
                'pelaporan' => $input,
                'kategori' => $input->kategori?->nama ?? 'Umum',
                'status' => $status,
                'feedback' => $feedback,
            ];

            if ($feedback) $feedbackList[] = ['text' => $feedback, 'kategori' => $input->kategori?->nama ?? 'Umum', 'date' => $asp->updated_at ?? $asp->created_at ?? $input->created_at];

            $progressSum += $statusMap[$status] ?? 0;
        }

        $aspirasiCount = $inputs->count();

        $count = max(1, $aspirasiCount);
        $avgProgress = (int) round($progressSum / $count);

        $completionCount = 0;
        foreach ($items as $it) {
            if ($it['status'] === 'Selesai') $completionCount++;
        }
        $completionPercent = (int) round(($completionCount / max(1, count($items))) * 100);

        // Count items with status 'Menunggu'
        $waitingCount = 0;
        foreach ($items as $it) {
            if (($it['status'] ?? '') === 'Menunggu') $waitingCount++;
        }

        // latest feedback (most recent)
        usort($feedbackList, function ($a, $b) {
            $ta = $a['date'] ? strtotime($a['date']) : 0;
            $tb = $b['date'] ? strtotime($b['date']) : 0;
            return $tb <=> $ta;
        });
        $latestFeedback = $feedbackList[0]['text'] ?? null;

        return view('siswa.dashboard', compact('siswa','items','avgProgress','completionPercent','aspirasiCount','latestFeedback','waitingCount'));
    }

    public function createAspirasi()
    {
        $user = auth()->user();
        if (! $user) return redirect()->route('login');

        // Allow accessing the create form even if the user doesn't have a linked siswa.
        $siswa = $user->siswa; // may be null
        $kategoris = Kategori::all();
        return view('siswa.create_aspirasi', compact('siswa','kategoris'));
    }

    public function storeAspirasi(Request $request)
    {
        $user = auth()->user();
        if (! $user) return redirect()->route('login');
        // Accept NIS from the form. If the logged-in user has a linked siswa, prefer it,
        // otherwise find or create a siswa record by provided NIS.
        $data = $request->validate([
            'nis' => 'required|string|max:20',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:255',
            'ket' => 'nullable|string|max:500',
        ]);

        // prefer linked siswa when available
        $siswa = $user->siswa;
        if (! $siswa) {
            // try find by nis
            $siswa = Siswa::where('nis', $data['nis'])->first();
            if (! $siswa) {
                // create a minimal siswa record (no user association)
                $siswa = Siswa::create([
                    'nis' => $data['nis'],
                    'kelas' => '-',
                    'user_id' => null,
                ]);
            }
        }

        // Ensure ket is not null (DB migration expects a value)
        $ket = $data['ket'] ?? '';

        InputAspirasi::create([
            'siswa_id' => $siswa->id,
            'kategori_id' => $data['kategori_id'],
            'lokasi' => $data['lokasi'],
            'ket' => $ket,
        ]);

        return redirect()->route('dashboard')->with('success', 'Aspirasi berhasil dikirim.');
    }
}
