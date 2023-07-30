<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kuisioner;
use App\Models\KuisionerDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function data(Request $request)
    {
        $query = Dosen::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('jmlpengisi', function ($query) {
                return  KuisionerDetail::where('dosen_id', $query->id)
                    ->distinct('mahasiswa_id')->count('mahasiswa_id');
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function index()
    {
        return view('admin.report.index');
    }
}
