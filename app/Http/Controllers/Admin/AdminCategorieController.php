<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categorie;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Categories - Online Store";
        $viewData["categories"] = Categorie::paginate(10); // 10 categories per page
    
        return view('admin.categories.index')->with("viewData", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>"required|string|max:255",
            'description'=>'required|string'
        ]);
        Categorie::create($request->only('name','description'));
        return back();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Edit Categorie - Online Store";
        $viewData["categorie"] = Categorie::findOrFail($id);
        return view('admin.categories.edit')->with("viewData", $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>"required|string|max:255",
            'description'=>'required|string'
        ]);
        $categorie = Categorie::findOrFail($id);


    $categorie->name = $request->input('name');
    $categorie->description = $request->input('description');


    $categorie->save();

  
    return redirect()->route('admin.categorie.index');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Categorie::destroy($id);
        return back();
    }
}
