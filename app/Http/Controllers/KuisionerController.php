<?php

namespace App\Http\Controllers;

use App\Models\Kuisioner;
use App\Models\KuisionerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KuisionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kuisioner.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $query = Kuisioner::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($query) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(`' . route('kuisioner.show', $query->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('kuisioner.destroy', $query->id) . '`, `' . 'terpilih' . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
            'quis' => 'required',
        ];

        $message = [
            'quis.required' => 'Kuisioner wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali'], 422);
        }

        $data = [
            'quis' => trim($request->quis),
        ];

        Kuisioner::create($data);

        return response()->json(['data' => $data, 'message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kuisioner $kuisioner)
    {
        return response()->json(['data' => $kuisioner]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kuisioner $kuisioner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuisioner $kuisioner)
    {
        $rules = [
            'quis' => 'required',
        ];

        $message = [
            'quis.required' => 'Kuisioner wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali'], 422);
        }

        $data = [
            'quis' => trim($request->quis),
        ];

        $kuisioner->update($data);

        return response()->json(['data' => $data, 'message' => 'Data berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuisioner $kuisioner)
    {
        $kuisioner->delete();

        $kuesioners = KuisionerDetail::where('quis_id', $kuisioner->id)->get();
        foreach ($kuesioners as $key => $item) {
            $item->delete();
        }

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
