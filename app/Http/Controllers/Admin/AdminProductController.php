<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Categorie;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $viewData = [];
        $viewData["categories"] = Categorie::all();
        $viewData["title"] = "Page Admin - Produits - Boutique en ligne";

        $fournisseurId = $request->input('fournisseur_id');

        if ($fournisseurId) {
            $viewData["products"] = Product::where('fournisseur_id', $fournisseurId)->get();
        } else {
            $viewData["products"] = Product::all();
        }

        $viewData["fournisseurs"] = Fournisseur::all();
        return view('admin.product.index')->with("viewData", $viewData);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity_store' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:1000',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            'categorie_id' => 'nullable|exists:categories,id|min:1',
        ]);
        $categorieId = $request->input('categorie_id', 1);
        $newProduct = new Product();
        $newProduct->name = $request->input('name');
        $newProduct->description = $request->input('description');
        $newProduct->price = $request->input('price');
        $newProduct->quantity_store = $request->input('quantity_store');
        $newProduct->categorie_id = $categorieId;
        $newProduct->fournisseur_id = $request->input('fournisseur_id');
        $newProduct->image = "game.png";
        $newProduct->save();

        if ($request->hasFile('image')) {
            $imageName = $newProduct->id . "." . $request->file('image')->extension();
            Storage::disk('public')->put(
                $imageName,
                file_get_contents($request->file('image')->getRealPath())
            );
            $newProduct->image = $imageName;
            $newProduct->save();
        }

        return back()->with('success', 'Produit créé avec succès!');
    }



    public function delete($id)
    {
        $product=Product::findOrFail($id);
        if($product->image && Storage::disk("public")->exists($product->image)){
            Storage::disk("public")->delete($product->image);
        }
        Product::destroy($id);
        return back();
    }

    public function edit($id)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Edit Product - Online Store";
        $viewData["fournisseurs"]=Fournisseur::all();
        $viewData["categories"] = Categorie::all();
        $viewData["product"] = Product::findOrFail($id);
        return view('admin.product.edit')->with("viewData", $viewData);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity_store' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:1000',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            'categorie_id' => 'nullable|exists:categories,id|min:1',
        ]);
        $categorieId = $request->input('categorie_id', 1);
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->quantity_store = $request->input('quantity_store');
        $product->categorie_id = $categorieId;
        $product->fournisseur_id = $request->input('fournisseur_id');

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imageName = $product->id . "." . $request->file('image')->extension();
            Storage::disk('public')->put(
                $imageName,
                file_get_contents($request->file('image')->getRealPath())
            );
            $product->image = $imageName;
        }
        $product->save();

        return redirect()->route('admin.home.index')->with('success', 'Produit mis à jour avec succès!');
    }


}
