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
        return $this->dashboardDataResponse();
    }

    public function dashboardData()
    {
        return $this->dashboardDataResponse();
    }

    private function dashboardDataResponse()
    {
        $user = auth()->user();
        if (! $user) {
            abort(401, 'Unauthorized');
        }

        $siswa = $user->siswa;
        if (! $siswa) {
            $siswa = Siswa::create([
                'user_id' => $user->id,
'nis' => $user->nis ?? substr($user->email, 0, 10),
                'kelas' => '-'
            ]);
        }

        // Load inputs directly to avoid issues with relationship caching; include aspirasi relation
        $inputs = InputAspirasi::where('siswa_id', $siswa->id)
            ->with(['kategori','aspirasi'])
            ->orderBy('created_at', 'desc')
            ->get();

        $items = [];
        $statusMap = ['Menunggu' => 0, 'Proses' => 50, 'Selesai' => 100];
        $progressSum = 0;
        $feedbackList = [];
        foreach ($inputs as $input) {
            // Prefer Aspirasi linked to this input (admin feedback/status). If none, default to Menunggu.
            $asp = $input->aspirasi ?? null;
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

        $data = compact('siswa','items','avgProgress','completionPercent','aspirasiCount','latestFeedback','waitingCount');

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($data);
        }

        return view('siswa.dashboard', $data);
    }

    public function createAspirasi()
    {
        $user = auth()->user();
        if (! $user) return redirect()->route('login');

        // Allow accessing the create form even if the user doesn't have a linked siswa.
        $siswa = $user->siswa; // may be null
        $kategoris = Kategori::orderBy('ket_kategori')->get();
        return view('siswa.create_aspirasi', compact('siswa','kategoris'));
    }

    public function storeAspirasi(Request $request)
    {
        $user = auth()->user();
        if (! $user) return redirect()->route('login');
        // Accept NIS from the form. If the logged-in user has a linked siswa, prefer it,
        // otherwise find or create a siswa record by provided NIS.
$data = $request->validate([
'nis' => 'required|string|max:10',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:255',
            'ket' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

$fotoPath = null;
        if ($request->hasFile('foto')) {
            $filename = \Illuminate\Support\Str::uuid() . '.' . $request->file('foto')->getClientOriginalExtension();
            $fotoPath = $request->file('foto')->storeAs('fotos', $filename, 'public');
        }

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
                    'user_id' => $user->id,
                ]);
            }
        }

        // Ensure ket is not null (DB migration expects a value)
        $ket = $data['ket'] ?? '';

$input = InputAspirasi::create([
            'siswa_id' => $siswa->id,
            'kategori_id' => $data['kategori_id'],
            'lokasi' => $data['lokasi'],
            'ket' => $ket,
            'foto' => $fotoPath,
        ]);

        // Create a corresponding Aspirasi record so admin can set status/feedback later
        try {
            Aspirasi::create([
                'kategori_id' => $data['kategori_id'],
                'status' => 'Menunggu',
                'feedback' => null,
                'input_pelaporan_id' => $input->id,
            ]);
        } catch (\Throwable $e) {
            // ignore if creation fails; admin can create later
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Aspirasi berhasil dikirim.',
                'redirect' => route('dashboard')
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Aspirasi berhasil dikirim.');
    }
}
