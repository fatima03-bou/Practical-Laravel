<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class AdminFournisseurController extends Controller
{
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Fournisseurs - Online Store";
        $viewData["fournisseurs"] = Fournisseur::all();
        return view('admin.fournisseurs.index', compact('viewData'));
    }

    // public function create()
    // {
    //     return view('admin.fournisseurs.create');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'raison_social' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tele' => 'required|string|max:20',
            'email' => 'required|email',
            'description' => 'nullable|string',
        ]);

        Fournisseur::create($request->all());
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur added successfully!');
    }

    public function show(Fournisseur $fournisseur)
    {
        return view('admin.fournisseurs.show', compact('fournisseur'));
    }

    public function edit($id)
    {
        $fournisseur = Fournisseur::find($id);
        if (!$fournisseur) {
            abort(404);
        }

        $viewData = [];
        $viewData["title"] = "Edit Fournisseur - Online Store";
        $viewData["fournisseur"] = $fournisseur;

        return view('admin.fournisseurs.edit', compact('viewData'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'raison_social' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tele' => 'required|string|max:20',
            'email' => 'required|email',
            'description' => 'nullable|string',
        ]);

        $fournisseur = Fournisseur::find($id);
        if (!$fournisseur) {
            abort(404);
        }

        $fournisseur->update($request->all());
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur updated successfully!');
    }

    public function destroy($id)
    {
        $fournisseur = Fournisseur::find($id);
        if (!$fournisseur) {
            abort(404);
        }

        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur deleted successfully!');
    }
}
