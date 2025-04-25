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
        // Validate the request
        Product::validate($request);
    
<<<<<<< HEAD
        // Create a new product instance
=======
>>>>>>> origin
        $newProduct = new Product();
    
        // Assign values to the product attributes
        $newProduct->name = $request->input('name');
        $newProduct->description = $request->input('description');
        $newProduct->price = $request->input('price');
        $newProduct->image = "game.png"; // Default image
        $newProduct->fournisseur_id = $request->input('fournisseur_id');

        // Assign category_id
<<<<<<< HEAD
        $newProduct->categorie_id = $request->input('category_id');
=======
        $newProduct->categorie_id = $request->input('categorie_id');
>>>>>>> origin
    
        // Save the product
        $newProduct->save();
    
<<<<<<< HEAD
        // Handle image upload if present
=======
>>>>>>> origin
        if ($request->hasFile('image')) {
            $imageName = $newProduct->id . "." . $request->file('image')->extension();
    
            Storage::disk('public')->put(
                $imageName,
                file_get_contents($request->file('image')->getRealPath())
            );
            $newProduct->image = $imageName; // Update the image field
            $newProduct->save(); // Save the updated image field
        }
    
<<<<<<< HEAD
        // Redirect or return response
        return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
=======
        return back();
>>>>>>> origin
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
<<<<<<< HEAD
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $product->category_id = $request->input('category_id');
=======
        $product->setName($request->input('name'));
        $product->setDescription($request->input('description'));
        $product->setPrice($request->input('price'));
        $product->categorie_id = $request->input('categorie_id');
>>>>>>> origin

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
