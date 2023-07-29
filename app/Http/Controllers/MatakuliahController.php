<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('admin.matakuliah.index');
    }

    public function data(Request $request)
    {
        $query = Matakuliah::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(`' . route('matakuliah.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('matakuliah.destroy', $query->id) . '`, `'. $query->name .'`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
            'kode' => 'required',
            'name' => 'required',
            'semester' => 'required',
            'sks' => 'required',
        ];

        $message = [
            'kode.required' => 'Kode matkul wajib diisi',
            'name.required' => 'Nama matkul wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'sks.required' => 'Sks wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'kode' => trim($request->kode),
            'name' => trim($request->name),
            'semester' => trim($request->semester),
            'sks' => trim($request->sks),
        ];

        $matakuliah = Matakuliah::create($data);

        return response()->json(['data' => $matakuliah, 'message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $matakuliah = Matakuliah::findOrfail($id);

        return response()->json(['data' => $matakuliah]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matakuliah $matakuliah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $rules = [
            'kode' => 'required',
            'name' => 'required',
            'semester' => 'required',
            'sks' => 'required',
        ];

        $message = [
            'kode.required' => 'Kode matkul wajib diisi',
            'name.required' => 'Nama matkul wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'sks.required' => 'Sks wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'kode' => trim($request->kode),
            'name' => trim($request->name),
            'semester' => trim($request->semester),
            'sks' => trim($request->sks),
        ];

        $matakuliah = Matakuliah::findOrfail($id);

        $matakuliah->update($data);

        return response()->json(['data' => $matakuliah, 'message' => 'Data berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $matakuliah = Matakuliah::findOrfail($id);

        $matakuliah->delete();

        return response()->json(['data' => $matakuliah, 'message' => 'Data berhasil dihapus']);
    }

    public function search(Request $request)
    {
         $query = Matakuliah::doesntHave('dosen_matakuliah');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('select_all', function ($query) {
                return '
                    <input type="checkbox" class="matakuliah_id" name="matakuliah_id[]" id="matakuliah_id" value="' . $query->id . '">
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
