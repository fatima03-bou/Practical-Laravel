<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return view('fournisseurs.index', compact('fournisseurs'));
    }

    public function create()
    {
        return view('fournisseurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'raison_social' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tele' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:fournisseurs',
            'description' => 'nullable|string|max:500',
        ]);

        Fournisseur::create($request->all());

        return redirect()->route('fournisseurs.index');
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'raison_social' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tele' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:fournisseurs,email,' . $fournisseur->id,
            'description' => 'nullable|string|max:500',
        ]);

        $fournisseur->update($request->all());

        return redirect()->route('fournisseurs.index');
    }

    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return redirect()->route('fournisseurs.index');
    }
}
