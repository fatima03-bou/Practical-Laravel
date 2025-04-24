<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Categorie;
use App\Models\fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Products - Online Store";
        $viewData["categories"] = Categorie::all();
        $viewData["fournisseurs"] = fournisseur::all();
        
        $categoryId = $request->query('categorie_id');
        $fournisseurId = $request->query('fournisseur_id');
        if ($categoryId) { 
            $viewData["products"] = Product::where('categorie_id', $categoryId)->get();
        }else if ($fournisseurId) { 
            $viewData["products"] = Product::where('fournisseur_id', $fournisseurId)->get();
        }
         else {
            $viewData["products"] = Product::all();
        }
        return view('admin.product.index')->with("viewData", $viewData);
    }


    public function store(Request $request)
    {
        // dd($request);
        Product::validate($request);
    
        $newProduct = new Product();
        $newProduct->setName($request->input('name'));
        $newProduct->setDescription($request->input('description'));
        $newProduct->setPrice($request->input('price'));
        $newProduct->setImage("game.png");
    
        // Assign category_id
        $newProduct->categorie_id = $request->input('categorie_id');
    
        $newProduct->save();
    
        if ($request->hasFile('image')) {
            $imageName = $newProduct->getId().".".$request->file('image')->extension();
            Storage::disk('public')->put(
                $imageName,
                file_get_contents($request->file('image')->getRealPath())
            );
            $newProduct->setImage($imageName);
            $newProduct->save();
        }
    
        return back();
    }
    

    public function delete($id)
    {
        Product::destroy($id);
        return back();
    }

    public function edit($id)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Edit Product - Online Store";
        $viewData["product"] = Product::findOrFail($id);
        $viewData["categories"] = Categorie::all();

        return view('admin.product.edit')->with("viewData", $viewData);
    }

    public function update(Request $request, $id)
    {
        Product::validate($request);

        $product = Product::findOrFail($id);
        $product->setName($request->input('name'));
        $product->setDescription($request->input('description'));
        $product->setPrice($request->input('price'));
        $product->categorie_id = $request->input('categorie_id');

        if ($request->hasFile('image')) {
            $imageName = $product->getId().".".$request->file('image')->extension();
            Storage::disk('public')->put(
                $imageName,
                file_get_contents($request->file('image')->getRealPath())
            );
            $product->setImage($imageName);
        }

        $product->save();
        return redirect()->route('admin.product.index');
    }
    public function export()  {
        return Excel::download(new ProductExport, 'product.xlsx');
    }
    public function import(Request $request){
        Excel::import(new ProductImport,  $request->file('file'));
        return redirect()->route('admin.product.index');
    
    }
}
