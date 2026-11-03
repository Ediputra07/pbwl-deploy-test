<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateMataKuliahRequest extends StoreMataKuliahRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['kode_mk'] = [
            'required', 'string', 'max:20',
            Rule::unique('mata_kuliahs', 'kode_mk')->ignore($this->route('mata_kuliah')),
        ];

        return $rules;
    }
}
