<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMataKuliahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Checkbox yang tidak dicentang tidak terkirim, jadi dipaksa menjadi true/false
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status_aktif' => $this->boolean('status_aktif'),
        ]);
    }

    public function rules(): array
    {
        return [
            'program_studi_id' => ['required', 'exists:program_studis,id'],
            'kode_mk'          => ['required', 'string', 'max:20', 'unique:mata_kuliahs,kode_mk'],
            'nama_mk'          => ['required', 'string', 'min:3', 'max:100'],
            'sks'              => ['required', 'integer', 'between:1,6'],
            'status_aktif'     => ['boolean'],
            'tanggal_dibuka'   => ['nullable', 'date', 'required_if:status_aktif,true'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'                   => ':attribute wajib diisi.',
            'string'                     => ':attribute harus berupa teks.',
            'integer'                    => ':attribute harus berupa angka bulat.',
            'date'                       => ':attribute harus berupa tanggal yang valid.',
            'kode_mk.unique'             => 'Kode mata kuliah :input sudah digunakan.',
            'kode_mk.max'                => 'Kode mata kuliah maksimal :max karakter.',
            'nama_mk.min'                => 'Nama mata kuliah minimal :min karakter.',
            'sks.between'                => 'SKS harus bernilai antara :min sampai :max.',
            'program_studi_id.exists'    => 'Program studi yang dipilih tidak valid.',
            'tanggal_dibuka.required_if' => 'Tanggal dibuka wajib diisi jika mata kuliah berstatus aktif.',
        ];
    }

    public function attributes(): array
    {
        return [
            'program_studi_id' => 'program studi',
            'kode_mk'          => 'kode mata kuliah',
            'nama_mk'          => 'nama mata kuliah',
            'sks'              => 'SKS',
            'tanggal_dibuka'   => 'tanggal dibuka',
        ];
    }
}
