<?php

namespace App\Services\Admin;

use App\Models\User;

class DataAdminService
{
    public function updatingAddAdmin($request)
    {
        $admin = User::find($request->user_id);
        $admin->update([
            'isAdmin' => true
        ]);

        return $admin;
    }

    public function deleteAdmin($user)
    {
        return $user->update([
            'isAdmin' => false
        ]);
    }
}
