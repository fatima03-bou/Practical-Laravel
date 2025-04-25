<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Http\Request;

class AdminDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les produits avec les remises associées
        $products = Product::with('discount')->get();

        // Passer les produits à la vue
        return view('admin.product.index', ['products' => $products]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:all,category,product',
            'percentage' => 'required|numeric|min:0|max:100',
            'rate' => 'required|numeric|min:0|max:100', 
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
      
        Discount::create($request->all());
    
        return redirect()->route('discounts.create')->with('success', 'Remise ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
