<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerDetail extends Model
{
    use HasFactory;
    protected $table = 'kuisioner';
    protected $guarded = ['id'];

    public function quis()
    {
        return $this->belongsTo(Kuisioner::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
