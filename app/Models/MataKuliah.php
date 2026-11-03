<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_studi_id', 'kode_mk', 'nama_mk', 'sks',
        'status_aktif', 'tanggal_dibuka',
    ];

    protected function casts(): array
    {
        return [
            'status_aktif'   => 'boolean',
            'tanggal_dibuka' => 'datetime',
        ];
    }

    public function scopeDibuka($query)
    {
        return $query->where('status_aktif', true);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'krs');
    }
}
