<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Products - Online Store";
        $viewData["subtitle"] = "List of products";

        $query = Product::with('discount', 'category'); 

        if ($request->has('on_sale') && $request->get('on_sale') == 1) {
            $query->whereHas('discount', function ($q) {
                $now = now();
                $q->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
            });
        }

        if ($request->has('categorie_id') && $request->get('categorie_id') != '') {
            $query->where('categorie_id', $request->get('categorie_id'));
        }

        // Paginate the filtered products
        $viewData["products"] = $query->paginate(8);

        // Get all categories for the filter dropdown
        $viewData["categories"] = Categorie::all();

        return view('product.index')->with("viewData", $viewData);
    }



    public function show($id)
    {
        $viewData = [];
        $product = Product::findOrFail($id);
        $viewData["title"] = $product->getName()." - Online Store";
        $viewData["subtitle"] =  $product->getName()." - Product information";
        $viewData["product"] = $product;
        // dd($viewData );
        return view('product.show')->with("viewData", $viewData);
    }
    
}
