<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        if ($request->has('category_id') && $request->get('category_id') != '') {
            $query->where('category_id', $request->get('category_id'));
        }

        // Paginate the filtered products
        $viewData["products"] = $query->paginate(8);

        // Get all categories for the filter dropdown
        $viewData["categories"] = Category::all();

        return view('product.index')->with("viewData", $viewData);
    }



    public function show($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $viewData["title"] = $product->getName()." - Online Store";
        $viewData["subtitle"] =  $product->getName()." - Product information";
        $viewData["product"] = $product;
        $viewData["categories"] = $categories;
        // dd($viewData );
        return view('product.show')->with("viewData", $viewData);
    }
    
}
