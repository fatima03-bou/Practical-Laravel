<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->filled('fournisseur_id')) {
            $query->where('fournisseur_id', $request->fournisseur_id);
        }
        
        // Paginate the results, 10 products per page
        $viewData = [
            'title' => 'Admin - Products',
            'products' => $query->paginate(10),  // Adding pagination here
            'categories' => Categorie::all(),
            'fournisseurs' => Fournisseur::all(),
        ];
        
        return view('admin.home.index', compact('viewData'));
    }

    
}
