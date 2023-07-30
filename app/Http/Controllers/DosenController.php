<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dosen.index');
    }

    public function data(Request $request)
    {
        $query = Dosen::orderBy('id', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                        <a href="' . route('dosen.detail', $query->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>
                        <button onclick="editForm(`' . route('dosen.show', $query->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('dosen.destroy', $query->id) . '`, `' . $query->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
            'name' => 'required',
            'jenis_kel' => 'required|in:Laki-laki,Perempuan'
        ];

        $messages = [
            'name.required' => 'Nama dosen wajib disi',
            'jenis_kel.required' => 'Jenis kelamin wajib disi',
            'jenis_kel.in' => 'Pilih sesuai',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        Dosen::create($data);

        return response()->json(['data' => $data, 'message' => 'Data dosen berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dosen = Dosen::findOrfail($id);

        return response()->json(['data' => $dosen]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'jenis_kel' => 'required|in:Laki-laki,Perempuan'
        ];

        $messages = [
            'name.required' => 'Nama dosen wajib disi',
            'jenis_kel.required' => 'Jenis kelamin wajib disi',
            'jenis_kel.in' => 'Pilih sesuai',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $dosen = Dosen::findOrfail($id);

        $dosen->update($data);

        return response()->json(['data' => $dosen, 'message' => 'Data dosen berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dosen = Dosen::findOrfail($id);
        $dosen->delete();

        return response()->json(['data' => $dosen, 'message' => 'Data dosen berhasil dihapus']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail($id)
    {
        $dosen = Dosen::findOrfail($id);

        return view('admin.dosen.detail', compact('dosen'));
    }

    /**
     * data matakuliah dosen.
     */
    public function matakuliahData(Request $request)
    {
        $query = Matakuliah::whereDoesntHave('dosen', function ($query) use ($request) {
            $query->where('dosen_id', $request->dosen);
        });

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

    /**
     * data matakuliah dosen.
     */
    public function getDosenMatakuliah(Request $request, $dosenId)
    {
        $query = Matakuliah::whereHas('dosen', function ($q) use ($dosenId) {
            $q->where('dosen_id', $dosenId);
        })->orderBy('id', 'ASC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('matakuliah', function ($query) {
                return $query->name;
            })
            ->addColumn('semester', function ($query) {
                return $query->semester;
            })
            ->addColumn('aksi', function ($query) {
                return '
                   <button onclick="deleteMatakuliah(`' . route('dosen.matakuliah_destroy', $query->id) . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }


    /**
     * Index detail matakuliah dosen.
     */
    public function dosenMatakuliahStore(Request $request)
    {
        $rules = [
            'dosen_id' => 'required',
            'matakuliah_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Matakuliah gagal dimasukan ke dalam kelas'], 422);
        }

        $dosen = Dosen::findOrfail($request->dosen_id);

        //cek apakah dosen sudah memilih mata kuliah
        if ($dosen->matakuliah()->where('matakuliah_id', $request->matakuliah_id)->exists()) {
            return response()->json(['message' => 'Dosen sudah mengambil matakuliah ini'], 422);
        }

        $dosen->matakuliah()->attach($request->matakuliah_id);

        return response()->json(['message' => 'Matakuliah berhasil disimpan']);
    }

    public function matakuliahDestroy($matakuliahId)
    {
        $matakuliah = Matakuliah::findOrfail($matakuliahId);

        $matakuliah->dosen()->detach();

        return response()->json(['message' => 'Matakuliah berhasil dihapus']);
    }
}
