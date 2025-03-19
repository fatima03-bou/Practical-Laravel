<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Products - Online Store";
        $viewData["subtitle"] = "List of products";

        // Initialisation de la requête pour récupérer les produits
        $query = Product::query();

        // Vérifier si un ID de catégorie est présent dans la requête
        if ($request->has('category_id') && $request->category_id != '') {
            // Filtrer les produits par la catégorie sélectionnée
            $query->where('categorie_id', $request->category_id);
        }

        // Exécuter la requête pour obtenir les produits filtrés
        $viewData["products"] = $query->get();

        // Récupérer toutes les catégories
        $viewData["categories"] = Categorie::all();

        // Retourner la vue avec les produits filtrés et les catégories
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
}
