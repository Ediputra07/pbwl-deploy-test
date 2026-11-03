<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nim'];

    public function mataKuliah()
    {
        return $this->belongsToMany(MataKuliah::class, 'krs');
    }
}
