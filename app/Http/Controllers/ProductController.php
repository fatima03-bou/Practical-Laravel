<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Products - Online Store";
        $viewData["subtitle"] = "List of products";
    
        $query = Product::query();
    
        // Filtrage par catégorie
        if ($request->has('categorie') && $request->categorie != '') {
            $query->where('categorie', $request->categorie);
        }
    
        // Filtrage des produits soldés
        if ($request->has('on_sale') && $request->on_sale) {
            $now = now();
            $query->where(function ($q) use ($now) {
                // Produits avec remise spécifique
                $q->whereHas('discounts', function ($q) use ($now) {
                    $q->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now);
                })
                // Produits avec remise par catégorie
                ->orWhereHas('categorie.discounts', function ($q) use ($now) {
                    $q->where('type', 'categorie')
                      ->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now);
                });
    
                // Vérifier s'il y a une remise globale active
                $globalDiscounts = Discount::where('type', 'global')
                    ->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now)
                    ->exists();
    
                if ($globalDiscounts) {
                    $q->orWhereNotNull('id');
                }
            });
        }
    
        $viewData["products"] = $query->paginate(12);
        $viewData["categories"] = Categorie::all();
        $viewData['fournisseurs'] = Fournisseur::all();
    
        return view('product.index')->with("viewData", $viewData);
    }
    

    public function show($id)
    {
        $viewData = [];
        $product = Product::findOrFail($id);
        $viewData["title"] = $product->getName()." - Online Store";
        $viewData["subtitle"] =  $product->getName()." - Product information";
        $viewData["product"] = $product;

        return view('product.show')->with("viewData", $viewData);
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Creation du produit
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->discount_price = $request->input('discount_price', null);
        $product->description = $request->input('description');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->discount_price = $request->input('discount_price', null);
        $product->description = $request->input('description');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
    }
}