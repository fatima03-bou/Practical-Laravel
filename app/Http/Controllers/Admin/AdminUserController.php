<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function index()
    {
        $viewData = [
            'title' => 'Admin - Users Management',
            'admins' => User::where('role', 'admin')->orderBy('name')->paginate(10)
        ];
        return view('admin.users.index', $viewData);
    }

    public function create()
    {
        return view('admin.users.create', ['title' => 'Create Admin User']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'balance' => 0
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user created successfully');
    }

    public function edit($id)
    {
        $viewData = [
            'title' => 'Edit Admin User',
            'admin' => User::findOrFail($id)
        ];
        return view('admin.users.edit', $viewData);
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($admin->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user updated successfully');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $admin->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user deleted successfully');
    }
}