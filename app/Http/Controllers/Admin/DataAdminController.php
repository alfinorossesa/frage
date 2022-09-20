<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\DataAdminRequest;
use App\Models\User;
use App\Services\Admin\DataAdminService;
use Illuminate\Http\Request;

class DataAdminController extends Controller
{
    protected $dataAdminService;
    public function __construct(DataAdminService $dataAdminService)
    {
        $this->dataAdminService = $dataAdminService;
    }

    public function index()
    {
        $users = User::where('isAdmin', true)->latest()->get();

        return view('admin.data-admin.index', compact('users'));
    }

    public function addAdmin()
    {
        $users = User::where('isAdmin', false)->latest()->get();

        return view('admin.data-admin.create', compact('users'));
    }

    public function addAdminUpdate(DataAdminRequest $request)
    {
        $this->dataAdminService->updatingAddAdmin($request);

        return redirect()->route('dataAdmin.index')->with('success', 'Add admin success!');
    }

    public function disAdmin(User $user)
    {
        $this->dataAdminService->deleteAdmin($user);

        return back()->with('destroy', 'Admin deleted!');
    }
}
