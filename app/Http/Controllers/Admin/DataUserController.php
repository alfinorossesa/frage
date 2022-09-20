<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DataUserController extends Controller
{
    public function index()
    {
        $users = User::where('isAdmin', false)->latest()->get();

        return view('admin.data-user.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.data-user.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dataUser.index')->with('destroy', 'User deleted!');
    }
}
