<?php

namespace App\Http\Controllers;

use App\Models\CombinedScore;
use App\Models\DataBerita;
use App\Models\DataFasilitas;
use App\Models\DataPanitia;
use App\Models\DataPendaftaran;
use App\Models\DataPelatihan;
use App\Models\DataTest;
use App\Models\QuotaPendaftaran;
use App\Models\StrukturPegawai;
use App\Models\User;
use App\Models\UserMasyarakat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardSummaryController extends Controller
{
    public function getSummary()
    {
        $currentYear = Carbon::now()->year;
        $summary = [];

        // --- Helper Functions ---
        $groupByField = function ($model, $field) {
            return $model::select($field, DB::raw('count(*) as total'))
                ->whereNotNull($field)
                ->groupBy($field)
                ->pluck('total', $field);
        };

        $monthlyTrend = function ($model, $dateField = 'created_at') use ($currentYear) {
            $data = $model::select(
                DB::raw('MONTH(' . $dateField . ') as month'),
                DB::raw('count(*) as total')
            )
                ->whereYear($dateField, $currentYear)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();
            
            $result = [];
            for ($m = 1; $m <= 12; $m++) {
                $result[$m] = $data[$m] ?? 0;
            }
            return $result;
        };

        $getAreaChartData = function ($model, $dataField) {
            return $model::select($dataField . ' as data', 'updated_at as date')
                ->orderBy('updated_at')
                ->get()
                ->toArray();
        };

        // --- Core Summaries for Visualization ---

        // DataPendaftaran Summary
        try {
            $summary['pendaftaran'] = [
                'total' => DataPendaftaran::count(),
                'monthly_trend' => $monthlyTrend(new DataPendaftaran()),
                'by_status' => $groupByField(new DataPendaftaran, 'status_pendaftaran'),
                'by_pendidikan' => $groupByField(new DataPendaftaran, 'pendidikan'),
                'area_chart' => $getAreaChartData(new DataPendaftaran(), 'nama'),
            ];
        } catch (\Exception $e) {
            $summary['pendaftaran'] = ['error' => $e->getMessage()];
        }

        // DataPelatihan Summary
        try {
            $summary['pelatihan'] = [
                'total' => DataPelatihan::count(),
                'monthly_trend' => $monthlyTrend(new DataPelatihan(), 'kegiatan_dimulai'),
                'by_jenis_bimtek' => $groupByField(new DataPelatihan, 'jenis_bimtek'),
                'by_angkatan' => $groupByField(new DataPelatihan, 'angkatan'),
            ];
        } catch (\Exception $e) {
            $summary['pelatihan'] = ['error' => $e->getMessage()];
        }

        // DataFasilitas Summary
        try {
            $summary['fasilitas'] = [
                'total' => DataFasilitas::count(),
                'monthly_trend' => $monthlyTrend(new DataFasilitas()),
                'by_kategori' => $groupByField(new DataFasilitas, 'kategori'),
                'by_status' => $groupByField(new DataFasilitas, 'status'),
                'area_chart' => $getAreaChartData(new DataFasilitas(), 'nama_fasilitas'),
            ];
        } catch (\Exception $e) {
            $summary['fasilitas'] = ['error' => $e->getMessage()];
        }

        // StrukturPegawai Summary
        try {
            $summary['struktur_pegawai'] = [
                'total' => StrukturPegawai::count(),
                'monthly_trend' => $monthlyTrend(new StrukturPegawai()),
                'by_jabatan' => $groupByField(new StrukturPegawai, 'jabatan'),
                'by_status' => $groupByField(new StrukturPegawai, 'status'),
                'area_chart' => $getAreaChartData(new StrukturPegawai(), 'nama'),
            ];
        } catch (\Exception $e) {
            $summary['struktur_pegawai'] = ['error' => $e->getMessage()];
        }
        
        // DataPanitia Summary
        try {
            $summary['panitia'] = [
                'total' => DataPanitia::count(),
                'monthly_trend' => $monthlyTrend(new DataPanitia()),
                'by_jabatan' => $groupByField(new DataPanitia, 'jabatan'),
            ];
        } catch (\Exception $e) {
            $summary['panitia'] = ['error' => $e->getMessage()];
        }

        // --- Other Summaries ---

        // QuotaPendaftaran Summary
// Ringkasan QuotaPendaftaran
try {
    $quota = QuotaPendaftaran::first();
    
    // Hitung jumlah total DataPendaftaran
    $registered_count = DataPendaftaran::count();
    
    // Log untuk debugging
    \Log::info("QuotaPendaftaran: ", [$quota]);
    \Log::info("Registered Count: $registered_count");

    if (!$quota) {
        $summary['quota'] = [
            'status' => 'tidak_diset',
            'limit' => 0,
            'registered' => $registered_count,
            'remaining' => 0,
            'message' => 'Tidak ada data kuota pendaftaran.'
        ];
    } else {
        $summary['quota'] = [
            'status' => $quota->status ? 'buka' : 'tutup',
            'limit' => $quota->quota,
            'registered' => $registered_count,
            'remaining' => max(0, $quota->quota - $registered_count),
        ];
    }
} catch (\Exception $e) {
    \Log::error("Error di QuotaPendaftaran: " . $e->getMessage());
    $summary['quota'] = [
        'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
        'status' => 'tidak_diset',
        'limit' => 0,
        'registered' => 0,
        'remaining' => 0,
    ];
}
        
        // CombinedScore Summary
        try {
            $summary['scores'] = [
                'total_participants' => CombinedScore::count(),
                'average_pretest' => round(CombinedScore::avg('pretest_score'), 2),
                'average_posttest' => round(CombinedScore::avg('posttest_score'), 2),
            ];
        } catch (\Exception $e) {
            $summary['scores'] = ['error' => $e->getMessage()];
        }

        // DataTest Summary
        try {
            $summary['test'] = [
                'total' => DataTest::count(),
                'by_kategori' => $groupByField(new DataTest, 'kategori'),
            ];
        } catch (\Exception $e) {
            $summary['test'] = ['error' => $e->getMessage()];
        }

        // UserMasyarakat Summary
        try {
            $summary['masyarakat'] = [
                'total' => UserMasyarakat::count(),
                'by_pendidikan' => $groupByField(new UserMasyarakat, 'pendidikan'),
            ];
        } catch (\Exception $e) {
            $summary['masyarakat'] = ['error' => $e->getMessage()];
        }

        // User (Akses) Summary
        try {
            $summary['users'] = [
                'total' => User::count(),
                'by_role' => $groupByField(new User, 'role'),
            ];
        } catch (\Exception $e) {
            $summary['users'] = ['error' => $e->getMessage()];
        }

        // Berita Breakdown
        try {
            $summary['berita'] = [
                'total' => DataBerita::count(),
                'by_jenis_konten' => $groupByField(new DataBerita, 'jenis_konten'),
                'area_chart' => $getAreaChartData(new DataBerita(), 'judul'),
            ];
        } catch (\Exception $e) {
            $summary['berita_error'] = $e->getMessage();
        }

        return response()->json($summary);
    }
}