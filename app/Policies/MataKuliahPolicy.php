<?php

namespace App\Policies;

use App\Models\MataKuliah;
use App\Models\User;

class MataKuliahPolicy
{
    public function update(User $user, MataKuliah $mataKuliah): bool
    {
        return $user->hasRole('admin')
            || ($user->hasRole('dosen')
                && $user->id === $mataKuliah->user_id);
    }

    public function delete(User $user, MataKuliah $mataKuliah): bool
    {
        return $this->update($user, $mataKuliah);
    }
}
