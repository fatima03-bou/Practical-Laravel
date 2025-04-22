<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Admin - Online Store";
        $viewData["products"] = Product::all();
        $viewData["categories"] = Categorie::all();
        $viewData["fournisseur"] = Fournisseur::all();
        return view('admin.home.index')->with("viewData", $viewData);
    }
}
