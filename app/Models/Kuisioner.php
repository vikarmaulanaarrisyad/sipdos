<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    use HasFactory;
    protected $table = 'quis';
    protected $guarded = ['id'];
}
