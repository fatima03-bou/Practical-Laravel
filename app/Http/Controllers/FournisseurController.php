<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        $viewData = [
            'title' => 'Suppliers',
            'fournisseurs' => Fournisseur::withCount('products')->get()
        ];
        return view('fournisseur.index', $viewData);
    }

    public function create()
    {
        return view('fournisseur.create', ['title' => 'Create Supplier']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'raison_social' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tele' => 'required|string|max:20',
            'email' => 'required|email|unique:fournisseurs',
            'description' => 'nullable|string'
        ]);

        Fournisseur::create($request->all());

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Supplier created successfully');
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseur.edit', [
            'title' => 'Edit Supplier',
            'fournisseur' => $fournisseur
        ]);
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'raison_social' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tele' => 'required|string|max:20',
            'email' => 'required|email|unique:fournisseurs,email,'.$fournisseur->id,
            'description' => 'nullable|string'
        ]);

        $fournisseur->update($request->all());

        return redirect()->route('fournisseurs.index')
            ->with('success', 'Supplier updated successfully');
    }

    public function destroy(Fournisseur $fournisseur)
    {
        if ($fournisseur->products()->exists()) {
            return back()->with('error', 'Cannot delete supplier with associated products');
        }

        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')
            ->with('success', 'Supplier deleted successfully');
    }
}