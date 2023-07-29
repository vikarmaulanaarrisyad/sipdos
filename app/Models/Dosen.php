<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';
    protected $fillable = ['name','jenis_kel'];

    public function dosen_kelas ()
    {
        return $this->belongsToMany(Kelas::class, 'dosen_kelas')->withTimestamps();
    }

    public function matakuliah ()
    {
        return $this->belongsToMany(Matakuliah::class, 'dosen_matakuliah')->withTimestamps();
    }

}
