<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    protected $table = 'krs';

    protected $fillable = ['mahasiswa_id', 'mata_kuliah_id'];
}
