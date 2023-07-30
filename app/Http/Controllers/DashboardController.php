<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kuisioner;
use App\Models\KuisionerDetail;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $totalMahasiswa = Mahasiswa::count();
            $totalDosen = Dosen::count();
            $totalKuesioner = Kuisioner::count();
            $jumlahMengisi = KuisionerDetail::distinct('mahasiswa_id')->count('mahasiswa_id');

            return view('admin.dashboard.index',compact([
                'totalMahasiswa',
                'totalDosen',
                'totalKuesioner',
                'jumlahMengisi'
            ]));
        } else {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            //apakah mahasiswa sudah mengisi kuisioner
            $kuesioner = KuisionerDetail::where('mahasiswa_id', $mahasiswa->id)->get();


            return view('mahasiswa.dashboard.index', compact('user', 'kuesioner'));
        }
    }
}
