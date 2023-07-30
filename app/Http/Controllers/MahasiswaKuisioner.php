<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kuisioner;
use App\Models\KuisionerDetail;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaKuisioner extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mahasiswa.kuisioner.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $mahasiswaSemester = Mahasiswa::has('user')->pluck('semester')->first();

        $mahasiswa = Mahasiswa::has('user')->first();


        //mendapatkan data semester
        $query = Matakuliah::whereHas('dosen')
            ->where('semester', $mahasiswaSemester)->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('dosen', function ($query) {
                foreach ($query->dosen as $dosen) {
                    return '<strong>' . $dosen->name . '</strong>' . '<br> <i class="fa fa-book text-muted" aria-hidden="true"></i> ' . $query->name . '- Semester ' . $query->semester;
                }
            })
            ->addColumn('status', function ($query) {

                $mahasiswa = Mahasiswa::where('user_id', auth()->user()->id)->first();

                foreach ($query->dosen as $dosen) {

                    $kuesioner = KuisionerDetail::where('dosen_id', $dosen->id)->where('mahasiswa_id', $mahasiswa->id)->get();

                    if ($kuesioner->isEmpty()) {
                        return '
                            <span class="badge badge-warning">Belum mengisi</span>
                        ';
                    }

                    return '
                        <span class="badge badge-success">Success</span>
                    ';
                }
                // foreach ($query->dosen as $dosen) {

                //     $kuesioner = KuisionerDetail::where('dosen_id', $dosen->id)->get();

                //     if ($kuesioner->isEmpty()) {
                //         return '
                //             <span class="badge badge-warning">Belum mengisi</span>
                //         ';
                //     }

                //     return '
                //         <span class="badge badge-success">Success</span>
                //     ';
                // }
            })
            ->addColumn('aksi', function ($query) {

                $mahasiswa = Mahasiswa::where('user_id', auth()->user()->id)->first();

                foreach ($query->dosen as $dosen) {

                    $kuesioner = KuisionerDetail::where('dosen_id', $dosen->id)->where('mahasiswa_id', $mahasiswa->id)->get();

                    if (!$kuesioner->isEmpty()) {
                        continue; // Skip this teacher and proceed to the next one
                    }

                    return '
                    <div class="btn-group">
                        <a href="' . route('quis.show', $dosen->id) . '" class="btn btn-sm btn-primary">Mulai Kuesioner<i class="ml-2 fas fa-arrow-right"></i></a>
                    </div>
                ';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->user()->id)->first();

        $rules = [
            'quis_id' => 'required|array'
        ];

        $message = [
            'quis_id' => 'Soal wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silahkan periksa kembali jawaban anda'], 422);
        }

        foreach ($request->quis_id as $key => $value) {
            KuisionerDetail::create([
                'quis_id' => $key,
                'dosen_id' => $request->dosen_id,
                'mahasiswa_id' => $mahasiswa->id,
                'bobot' => $value
            ]);
        }

        $jumlahMengisi = KuisionerDetail::where('dosen_id', $request->dosen_id)
            ->distinct('mahasiswa_id')->count('mahasiswa_id');

        $bobot = KuisionerDetail::where('mahasiswa_id', $mahasiswa->id)
            ->where('dosen_id', $request->dosen_id)->sum('bobot');

        $pertanyaan = Kuisioner::count();

        $skor = $bobot / $pertanyaan;

        $nilai = $skor / $jumlahMengisi;

        $keterangan = $this->keterangan($nilai);

        $dosen =  Dosen::findOrfail($request->dosen_id);

        $data = [
            'nilai' => $nilai,
            'keterangan' => $keterangan,
        ];

        $dosen->update($data);

        return response()->json(['message' => 'Jawaban anda berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dosen = Dosen::findOrfail($id);
        $kuesioner = Kuisioner::all();

        return view('mahasiswa.kuisioner.show', compact('dosen', 'kuesioner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function keterangan($nilai)
    {
        if ($nilai >= 4.5 && $nilai <= 5) {
            return 'Sangat Baik';
        } elseif ($nilai >= 3.5 && $nilai < 4.5) {
            return 'Baik';
        } elseif ($nilai >= 2.5 && $nilai < 3.5) {
            return 'Cukup';
        } elseif ($nilai >= 1.5 && $nilai < 2.5) {
            return 'Kurang';
        } elseif ($nilai >= 0 && $nilai < 1.5) {
            return 'Sangat Kurang';
        } else {
            return '-';
        }
    }
}
