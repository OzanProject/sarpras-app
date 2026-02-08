<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
  public function index()
  {
    Gate::authorize('role.view');
    $roles = Role::withCount('users')->get();
    return view('admin.role.index', compact('roles'));
  }

  public function create()
  {
    Gate::authorize('role.create');
    $permissions = Permission::all()->groupBy('group');
    return view('admin.role.create', compact('permissions'));
  }

  public function store(Request $request)
  {
    Gate::authorize('role.create');
    $request->validate([
      'name' => ['required', 'string', 'max:255', 'unique:roles'],
      'description' => ['nullable', 'string', 'max:255'],
      'permissions' => ['array'],
    ]);

    $role = Role::create($request->only('name', 'description'));

    if ($request->has('permissions')) {
      $role->permissions()->sync($request->permissions);
    }

    return redirect()->route('role.index')->with('success', 'Hak akses berhasil ditambahkan.');
  }

  public function edit(Role $role)
  {
    Gate::authorize('role.edit');
    $permissions = Permission::all()->groupBy('group');
    return view('admin.role.edit', compact('role', 'permissions'));
  }

  public function update(Request $request, Role $role)
  {
    Gate::authorize('role.edit');
    $request->validate([
      'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
      'description' => ['nullable', 'string', 'max:255'],
      'permissions' => ['array'],
    ]);

    $role->update($request->only('name', 'description'));

    if ($request->has('permissions')) {
      $role->permissions()->sync($request->permissions);
    } else {
      $role->permissions()->detach();
    }

    return redirect()->route('role.index')->with('success', 'Hak akses berhasil diperbarui.');
  }

  public function destroy(Role $role)
  {
    Gate::authorize('role.delete');
    if ($role->users()->count() > 0) {
      return back()->with('error', 'Tidak dapat menghapus role ini karena masih digunakan oleh user.');
    }

    $role->delete();
    return redirect()->route('role.index')->with('success', 'Hak akses berhasil dihapus.');
  }
}
