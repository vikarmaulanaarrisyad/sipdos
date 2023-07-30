<?php

namespace App\Http\Controllers;

use App\Models\KuisionerDetail;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.mahasiswa.index');
    }

    public function data(Request $request)
    {
        $query = Mahasiswa::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('kelas_id', function ($query) {
                return $query->kelas->name;
            })
            ->addColumn('semester', function ($query) {
                return 'Semester '. $query->semester;
            })
            ->addColumn('aksi', function ($query) {
                // <button onclick="editForm(`' . route('mahasiswa.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                return '
                    <div class="btn-group">
                        <button onclick="deleteData(`' . route('mahasiswa.destroy', $query->id) . '`, `' . $query->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                    </div>
                ';
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
        $rules = [
            'nim' => 'required',
            'name' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kel' => 'required',
        ];

        $message = [
            'nim.required' => 'NIM wajib diisi',
            'name.required' => 'Nama wajib diisi',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
            'jenis_kel.required' => 'Jenis kelamin wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'nim' => trim($request->nim),
            'name' => trim($request->name),
            'tgl_lahir' => trim($request->tgl_lahir),
            'jenis_kel' => trim($request->jenis_kel),
        ];

        $mahasiswa = Mahasiswa::create($data);

        return response()->json(['data' => $mahasiswa, 'message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        $mahasiswa->user()->delete();

        $kuesioner = KuisionerDetail::where('mahasiswa_id', $mahasiswa->id)->get();
        foreach ($kuesioner as $key => $item) {
            $item->delete();
        }
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
