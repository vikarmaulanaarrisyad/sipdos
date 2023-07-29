<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\KuisionerDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return view('admin.dashboard.index');
        } else {
            $dosen = Dosen::pluck('id');

            //apakah mahasiswa sudah mengisi kuisioner
            $kuisionerDetail = KuisionerDetail::where('mahasiswa_id', $user->id)->get();

            return view('mahasiswa.dashboard.index', compact('user', 'kuisionerDetail'));
        }
    }
}
