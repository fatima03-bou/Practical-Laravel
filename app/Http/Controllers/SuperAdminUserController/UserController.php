<?php

namespace App\Http\Controllers\SuperAdminUserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return view('superAdmin.index', compact('users'));
    }

    public function showCreateAdminForm()
    {
        return view("superAdmin.createAdmin");
    }
    
    public function createAdmin(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect("/superAdmin")->with('success', 'Admin created successfully!');
    }
}
