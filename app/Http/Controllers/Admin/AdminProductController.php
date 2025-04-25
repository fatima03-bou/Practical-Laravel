<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Categorie;
use App\Models\fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Products - Online Store";
        $viewData["categories"] = Categorie::all();
        $viewData["fournisseurs"] = fournisseur::all();
        $products = Product::with('discount')->get();
        $productsQuery = Product::query();

        if ($request->filled('category_id')) {
            $productsQuery->where('categorie_id', $request->category_id);
        }

        if ($request->filled('fournisseur_id')) {
            $productsQuery->where('fournisseur_id', $request->fournisseur_id);
        }

        $viewData["products"] = $productsQuery->get();

        return view('admin.product.index')->with("viewData", $viewData);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $newProduct = new Product();
        $newProduct->name = $request->name;
        $newProduct->description = $request->description;
        $newProduct->price = $request->price;
        $newProduct->fournisseur_id = $request->fournisseur_id;
        $newProduct->categorie_id = $request->categorie_id;
        $newProduct->image = "default.png";
        $newProduct->save();

        if ($request->hasFile('image')) {
            $imageName = $newProduct->id . '.' . $request->file('image')->extension();
            Storage::disk('public')->put($imageName, file_get_contents($request->file('image')->getRealPath()));
            $newProduct->image = $imageName;
            $newProduct->save();
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Edit Product - Online Store";
        $viewData["product"] = Product::findOrFail($id);
        $viewData["categories"] = Categorie::all();
        $viewData["fournisseurs"] = fournisseur::all();

        return view('admin.product.edit')->with("viewData", $viewData);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->fournisseur_id = $request->fournisseur_id;
        $product->categorie_id = $request->categorie_id;

        if ($request->hasFile('image')) {
            $imageName = $product->id . "." . $request->file('image')->extension();
            Storage::disk('public')->put($imageName, file_get_contents($request->file('image')->getRealPath()));
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
    }

    public function delete($id)
    {
        Product::destroy($id);
        return back()->with('success', 'Product deleted successfully!');
    }

    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new ProductImport, $request->file('file'));
        return redirect()->route('admin.product.index')->with('success', 'Products imported successfully!');
    }
}
