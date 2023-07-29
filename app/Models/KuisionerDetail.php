<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerDetail extends Model
{
    use HasFactory;
    protected $table = 'kuisioner';
    protected $guarded = ['id'];
}
