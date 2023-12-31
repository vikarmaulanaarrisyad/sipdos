<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\KuisionerDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }

    public function data(Request $request)
    {
        // Ambil data Dosen beserta nilai
        $dosens = Dosen::with('kuisionerDetails')->get();

        // Urutkan data Dosen berdasarkan nilai secara descending
        $dosens = $dosens->sortByDesc('nilai');

        // Berikan peringkat berdasarkan urutan nilai
        $peringkat = 1;
        foreach ($dosens as $dosen) {
            $dosen->peringkat = $dosen->nilai == 0 ? '-' : $peringkat;
            $dosen->keterangan = $dosen->keterangan;
            $peringkat++;
        }

        return datatables($dosens)
            ->addIndexColumn()
            ->addColumn('jmlpengisi', function ($dosen) {
                return  KuisionerDetail::where('dosen_id', $dosen->id)
                    ->distinct('mahasiswa_id')->count('mahasiswa_id');
            })
            ->addColumn('rangking', function ($dosen) {
                return $dosen->peringkat;
            })
            ->addColumn('keterangan', function ($dosen) {
                return $dosen->keterangan;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function exportPDF()
    {
        // Ambil data Dosen beserta nilai
        $data = Dosen::orderBy('nilai', 'Desc')->get();

        // Berikan peringkat berdasarkan urutan nilai
        $peringkat = 1;

        // Berikan peringkat berdasarkan urutan nilai
        foreach ($data as $ds) {
            $keterangan = $this->getKeterangan($ds->nilai);
            $jumlahPengisi = $this->jumlahPengisi($ds);

            if ($jumlahPengisi === 0) {
                $keterangan = 'Belum Ada Pengisi';
            }

            $ds->peringkat = $ds->nilai === 0 ? '-' : $peringkat;
            $peringkat++;

            $ds->jumlahPengisi = $jumlahPengisi; // Simpan jumlah pengisi ke objek Dosen
            $ds->keterangan = $keterangan; // Simpan keterangan ke objek Dosen
        }

        $pdf = PDF::loadView('admin.report.pdf', compact('data'));

        return $pdf->stream('Laporan-penilaian-dosen-' . date('Y-m-d-his') . '.pdf');
    }

    public function jumlahPengisi($dosen)
    {
        $jmlhPengisi = KuisionerDetail::where('dosen_id', $dosen->id)
            ->distinct('mahasiswa_id')
            ->count('mahasiswa_id');

        return $jmlhPengisi > 0 ? $jmlhPengisi : 0;
    }

    public function getKeterangan($nilai)
    {
        if ($nilai >= 3.5 && $nilai <= 4) {
            return 'Sangat Baik';
        } elseif ($nilai >= 2.5 && $nilai < 3.4) {
            return 'Baik';
        } elseif ($nilai >= 1.5 && $nilai < 2.4) {
            return 'Cukup';
        } elseif ($nilai >= 0 && $nilai < 1.4) {
            return 'Kurang';
        } else {
            return '-';
        }
    }
}
