<x-modal data-backdrop="static" data-keyboard="false" size="modal-md" class="modal-matakuliah">
    <x-slot name="title">
        Tambah Daftar Matakuliah
    </x-slot>

    @method('POST')

    <x-table class="matkul">
        <x-slot name="thead">
            <tr>
                <th>
                    <input type="checkbox" name="select_all[]" id="select_all" class="select_all">
                </th>
                <th>No</th>
                <th>Matkul</th>
                <th>Semester</th>
            </tr>
        </x-slot>
    </x-table>


    <x-slot name="footer">
            <button type="button" onclick="submitForm('{{ route('dosen.matakuliah.store') }}', '{{ $dosen->id }}')" class="btn btn-sm btn-outline-primary" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
