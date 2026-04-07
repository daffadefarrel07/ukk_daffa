<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->username;
        $password = $request->password;

        // Try to find user by email or name
        $user = User::where('email', $username)
            ->orWhere('name', $username)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            // Log user in and mark admin session flag
            Auth::login($user);
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_username', $user->name ?? 'Admin');
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!'
        ])->onlyInput('username');
    }

    public function dashboard(Request $request)
    {
        if (! $request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $kategoriId = $request->get('kategori_id');
        $siswaId = $request->get('siswa_id');

        $query = InputAspirasi::with(['siswa.user', 'kategori'])
            ->orderBy('created_at', 'desc');

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        if ($siswaId) {
            $query->where('siswa_id', $siswaId);
        }

        $itemsRaw = $query->get();

        $items = $itemsRaw->map(function ($p) {
            return [
                'pelaporan' => $p,
                'siswa' => $p->siswa,
                'kategori' => $p->kategori->nama ?? 'Tanpa Kategori',
                'status' => 'Pending', // Demo: bisa di-update dengan join Aspirasi nanti
                'feedback' => '-',
            ];
        });

        $total = InputAspirasi::count();

        // By Category
        $byCategory = InputAspirasi::groupBy('kategori_id')
            ->selectRaw('kategori_id, count(*) as count')
            ->pluck('count', 'kategori_id')
            ->map(function ($count, $id) {
                $kat = Kategori::find($id);
                return [
                    'kategori' => $kat ? $kat->nama : 'Unknown',
                    'count' => (int) $count
                ];
            })->values();

        // By Siswa
        $bySiswa = InputAspirasi::groupBy('siswa_id')
            ->selectRaw('siswa_id, count(*) as count')
            ->get()
            ->map(function ($item) {
                $s = Siswa::find($item->siswa_id);
                return [
                    'siswa' => $s ? $s->nis : 'Unknown',
                    'count' => $item->count
                ];
            });

        // By Date
        $byDate = DB::table('input_aspirasis')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as cnt')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        $kategoris = Kategori::all();
        $siswas = Siswa::all();

        return view('admin.dashboard', compact(
            'total',
            'byCategory',
            'bySiswa',
            'byDate',
            'kategoris',
            'siswas',
            'items'
        ));
    }

    public function logoutAdmin(Request $request)
    {
        $request->session()->forget(['admin_logged_in', 'admin_username']);
        $request->session()->regenerate();
        return redirect()->route('admin.login');
    }

    // List all input aspirasi (detail)
    public function listAspirasi(Request $request)
    {
        $items = InputAspirasi::with(['siswa.user','kategori'])->orderBy('created_at','desc')->get();
        return view('admin.aspirasi', compact('items'));
    }

    // Show aspirasi status summary
    public function aspirasiStatus(Request $request)
    {
        $byStatus = Aspirasi::groupBy('status')
            ->selectRaw('status, count(*) as count')
            ->pluck('count','status');

        return view('admin.status', compact('byStatus'));
    }

    // Show aspirasi feedback list
    public function aspirasiFeedback(Request $request)
    {
        $items = Aspirasi::with('kategori')->whereNotNull('feedback')->orderBy('updated_at','desc')->get();
        return view('admin.feedback', compact('items'));
    }

    // Show edit form for Aspirasi (status & feedback)
    public function editAspirasi($id)
    {
        $asp = Aspirasi::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.edit_aspirasi', compact('asp','kategoris'));
    }

    // Update aspirasi status and feedback
    public function updateAspirasi(Request $request, $id)
    {
        $asp = Aspirasi::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string',
        ]);

        $asp->status = $data['status'];
        $asp->feedback = $data['feedback'] ?? null;
        $asp->save();

        return redirect()->route('admin.aspirasi.feedback')->with('success','Aspirasi diperbarui.');
    }
}

