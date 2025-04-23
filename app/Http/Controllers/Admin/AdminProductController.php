<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

            'price' => 'required|numeric|min:1',
            'quantity_store' => 'required|integer|min:1',
            'image' => 'required|image|max:2048',
            'description' => 'required|string|max:1000',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'categorie_id' => 'required|exists:categories,id|min:1',
        ]);

        $quantityStore = $request->input('quantity_store');
        if ($quantityStore < 1) {
            return back()->with('error', 'La quantité en stock doit être supérieure ou égale à 1.');
        }

        $categorieId = $request->input('categorie_id', 1);
        $newProduct = new Product();
        $newProduct->name = $request->input('name');
        $newProduct->description = $request->input('description');
        $newProduct->price = $request->input('price');
        $newProduct->quantity_store = $quantityStore;
        $newProduct->categorie_id = $categorieId;
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
        $product = Product::findOrFail($id);
        if ($product->image && Storage::disk("public")->exists($product->image)) {
            Storage::disk("public")->delete($product->image);
        }
        Product::destroy($id);
        return back();
    }

    public function edit($id)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Edit Product - Online Store";
        $viewData["fournisseurs"] = Fournisseur::all();
        $viewData["categories"] = Categorie::all();
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
        $product->quantity_store = $quantityStore;
        $product->categorie_id = $categorieId;
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

    public function exportCSV()
    {
        $products = Product::all();
        $csvData = [];

        $csvData[] = ['ID', 'Name', 'Price', 'Category', 'Quantity'];
        foreach ($products as $product) {
            $csvData[] = [
                $product->id,
                $product->name,
                $product->price,
                optional($product->categorie)->name,
                $product->quantity_store,
            ];
        }
        $response = new StreamedResponse(function () use ($csvData) {
            $handle = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="products.csv"');

        return $response;
    }
    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');

        if (!$file) {
            return back()->with('error', 'Aucun fichier sélectionné.');
        }

        $filePath = $file->getRealPath();
        $handle = fopen($filePath, 'r');

        if (!$handle) {
            return back()->with('error', 'Impossible d\'ouvrir le fichier.');
        }
        fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if (count($row) < 7) {
                continue;
            }
            $quantityStore = isset($row[4]) && $row[4] >= 1 ? $row[4] : 1;
            Product::updateOrCreate(
                ['id' => $row[0]],
                [
                    'name' => $row[1],
                    'description' => $row[2],
                    'price' => $row[3],
                    'quantity_store' => $quantityStore,
                    'categorie_id' => Categorie::firstOrCreate(['name' => $row[5]])->id,
                    'fournisseur_id' => Fournisseur::firstOrCreate(['name' => $row[6]])->id,
                ]
            );
        }

        fclose($handle);

        return back()->with('success', 'Importation réussie !');
    }

}
