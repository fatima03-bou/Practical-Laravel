<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


class AdminUserController extends Controller
{

    public function index()
    {

        $admins = User::whereIn('role', ['admin'])->orderBy('name')->paginate(10);
        return view('admin.users.index', compact('admins'));
    }



    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => "required|string",
                'email' => "required|email:dns|unique:users",
                'password' => "required|string|min:6|confirmed",
            ],
            [
                'email.email' => 'Format d\'email invalide.',
                'email.dns' => 'Le domaine de l\'email n\'existe pas.',
                'email.unique' => 'Cet email est déjà pris.',
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'balance' => 0
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin user created succefully');
    }


    function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
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
        return redirect()->route('admin.users.index')->with('succes', 'Admin user updateed successfully');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.users.edit', compact('admin'));
    }


    function create()
    {
        return view('admin.users.create');
    }


    function show($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.users.show', compact('admin'));
    }


    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You can not delete your own account');
        }
        $admin->delete();
        return redirect()->route('admin.users.index')->with('success', 'Admin user deleted successfully');
    }
}
