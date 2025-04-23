<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Product  ;
class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::all();
        $products = Product::all();
    
        $viewData = [];
        $viewData["title"] = "Créer une remise - Admin";
        $viewData["categories"] = $categories;
        $viewData["products"] = $products;
        return view('admin.discounts.create')->with("viewData", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    
        \App\Models\Discount::create($request->all());
    
        return redirect()->route('discounts.create')->with('success', 'Remise ajoutes avec Success');
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