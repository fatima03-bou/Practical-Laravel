<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::with(['product', 'category'])->get(); // تصحيح الاسم إلى 'category'
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.discounts.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:global,Category,product',
            'rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'Category_id' => 'nullable|required_if:type,Category|exists:categories,id',
            'product_id' => 'nullable|required_if:type,product|exists:products,id',
        ]);

        Discount::create($validated);

        if ($validated['type'] === 'product' && isset($validated['product_id'])) {
            $product = Product::find($validated['product_id']);
            $discountedPrice = $product->price * (1 - $validated['rate'] / 100);
            $product->update(['discount_price' => $discountedPrice]);
        }

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Remise créée avec succès');
    }

    public function edit(Discount $discount)
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.discounts.edit', compact('discount', 'categories', 'products'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:global,Category,product',
            'rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'Category_id' => 'nullable|required_if:type,Category|exists:categories,id',
            'product_id' => 'nullable|required_if:type,product|exists:products,id',
        ]);

        $discount->update($validated);

        if ($validated['type'] === 'product' && isset($validated['product_id'])) {
            $product = Product::find($validated['product_id']);
            $discountedPrice = $product->price * (1 - $validated['rate'] / 100);
            $product->update(['discount_price' => $discountedPrice]);
        }

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Remise mise à jour avec succès');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Remise supprimée avec succès');
    }
}
