<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $table = 'matakuliah';

    public function dosen_matakuliah()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_matakuliah')->withTimestamps();
    }

}
