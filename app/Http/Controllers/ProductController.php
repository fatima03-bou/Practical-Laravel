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
       
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('categorie_id', $request->category_id);
        }

        if ($request->has('fournisseur_id') && $request->fournisseur_id != '') {
            $query->where('fournisseur_id', $request->fournisseur_id);
        }

        if ($request->has('on_sale') && $request->on_sale) {
            $now = now();
            $query->where(function ($q) use ($now) {
                $q->whereHas('discounts', function ($q) use ($now) {
                    $q->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now);
                })->orWhereHas('category.discounts', function ($q) use ($now) {
                    $q->where('type', 'category')
                        ->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now);
                });

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
        $viewData["fournisseurs"] = Fournisseur::all(); 

        return view('product.index')->with("viewData", $viewData);
    }

    public function show($id)
    {
        $viewData = [];
        $product = Product::findOrFail($id);
        $viewData["title"] = $product->getName() . " - Online Store";
        $viewData["subtitle"] = $product->getName() . " - Product information";
        $viewData["product"] = $product;

        return view('product.show')->with("viewData", $viewData);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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