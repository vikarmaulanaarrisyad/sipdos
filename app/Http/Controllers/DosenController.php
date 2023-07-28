<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('admin.dosen.index');
    }

    public function data (Request $request) 
    {
        $query = Dosen::orderBy('id','DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                        <a href="'. route('dosen.detail', $query->id) .'" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>
                        <button onclick="editForm(`' . route('dosen.show', $query->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('dosen.destroy', $query->id) . '`, `'. $query->name .'`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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

        return view('admin.dosen.detail',compact('dosen'));
    }
}
