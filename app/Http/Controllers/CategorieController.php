<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Categorie::all();
        return view("categorie.index",compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("categorie.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        "name" => "required|string|max:255",
        "description" => "string", 
    ]);
    Categorie::create($request->only(['name', 'description']));

    return redirect()->route("categorie.index");
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categorie=Categorie::findOrFail($id);
        return view("categorie.edit",compact("categorie"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name"=>"required|string|max:255",
            "descpription"=>"string",
        ]);
        $categorie=Categorie::findOrFail($id);
        $categorie->update($request->all());
        return redirect()->route("categorie.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie=Categorie::findOrFail($id);
        $categorie->delete();
        return redirect()->route("categorie.index");
    }
}
