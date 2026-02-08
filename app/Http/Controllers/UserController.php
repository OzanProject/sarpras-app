<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        \Illuminate\Support\Facades\Gate::authorize('user.view');
        // Sort by role_id (admin=1, user=2 usually), then by approval status, then by latest
        $users = User::with('role')->orderBy('role_id')->orderBy('is_approved', 'asc')->latest()->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('user.create');
        $roles = \App\Models\Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('user.create');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role_id' => $request->role_id,
            'is_approved' => true, // Auto modify for admin created users
            'email_verified_at' => now(),
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        \Illuminate\Support\Facades\Gate::authorize('user.edit');
        $user = User::findOrFail($id);
        $roles = \App\Models\Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        \Illuminate\Support\Facades\Gate::authorize('user.edit');
        $user = User::findOrFail($id);

        // PROTECT SUPER ADMIN (ID 1)
        if ($user->id == 1) {
            // Only allow updating own profile if authenticated user is ID 1, but prevent changing Role
            if (auth()->id() != 1) {
                return back()->with('error', 'Anda tidak memiliki izin untuk mengubah data Super Admin.');
            }
            // If ID 1 is updating themselves, force role to remain Admin (ID 1)
            $request->merge(['role_id' => 1]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        // If approval status change is needed, we can add it here too. 
        // For now, let's assume editing doesn't automatically approve, or we can add a checkbox.
        // Let's stick to the request: Name, Role, Password.

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function approve($id)
    {
        \Illuminate\Support\Facades\Gate::authorize('user.edit');
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);

        return back()->with('success', 'User berhasil disetujui.');
    }

    public function destroy($id)
    {
        \Illuminate\Support\Facades\Gate::authorize('user.delete');
        $user = User::findOrFail($id);

        // PROTECT SUPER ADMIN (ID 1) and SELF DELETION
        if ($user->id == 1) {
            return back()->with('error', 'Akun Super Admin (ID 1) tidak dapat dihapus!');
        }

        if ($user->id == auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
