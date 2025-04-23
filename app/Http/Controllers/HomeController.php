<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Categorie;
class HomeController extends Controller
{
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Home Page - Online Store";
        $showImages = false; // Set this based on your condition
        
        // Fetch products from the database
        $viewData["products"] = Product::with('discount')->get(); // or use any query you need, e.g., Product::paginate(10);
     
        $viewData["categories"] =Categorie::all(); 
        // Pass products to the view
        return view('home.index', [
            'products' => $viewData["products"],
            'categories' => $viewData["categories"],
            'showImages' => $showImages
        ]);;
    }

    public function about()
    {
        $viewData = [];
        $viewData["title"] = "About us - Online Store";
        $viewData["subtitle"] =  "About us";
        $viewData["description"] =  "This is an about page ...";
        $viewData["author"] = "Developed by: Your Name";
        return view('home.about')->with("viewData", $viewData);
    }
}
