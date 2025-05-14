<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{




        
    function __construct()
    {

        $this->middleware('permission:products', ['only' => ['index']]);
        $this->middleware('permission:Add product', ['only' => ['create','store']]);
        $this->middleware('permission:edit product', ['only' => ['edit','update']]);
        $this->middleware('permission:Delete product', ['only' => ['destroy']]);

    }





    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $sections = section::all();
        $products = Product::all();
        return view('products.products', compact(['products', 'sections']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'section_id' => 'required',
            'description' => 'required',
        ], [


            'product_name.required' => 'Please enter the Product name',
            'section_id.required' => 'Please enter the section name',
            'description.required' => 'Please enter the description',

        ]);
        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'The product has been added successfully');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = section::where('section_name', $request->section_name)->first()->id;

        $product = product::findOrFail($request->pro_id);



        $product->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,

        ]);

        session()->flash('Edit', 'The product has been successfully modified');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {
        $product = Product::findOrFail($request->pro_id);
        $product->delete();
        session()->flash('delete', 'The product has been successfully deleted');
        return redirect('/products');
    }
}
