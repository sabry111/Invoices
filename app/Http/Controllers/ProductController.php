<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {

        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('sections', 'products'));
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

        $request->validate([
            'product_name' => 'required|max:255',
            'section_id' => 'required',
        ],
            [
                'product_name.required' => 'يرجى إدخال اسم المنتج',
                'section_id.required' => 'يرجى اختيار اسم القسم',
            ]);

        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);

        return redirect(route('products.index'));
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
    public function update(Request $request, Product $product)
    {

        // dd($request->all());
        $request->validate([
            'product_name' => 'required|max:255',
            'section_name' => 'required',
        ],
            [
                'product_name.required' => 'يرجى إدخال اسم المنتج',
                'section_name.required' => 'يرجى اختيار اسم القسم',
            ]);

        $section_id = Section::where('section_name', $request->section_name)->first()->id;
        $product = Product::findorfail($request->id);
        $product->update([
            'product_name' => $request->product_name,
            'section_id' => $section_id,
            'description' => $request->description,
        ]);

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        $product->delete();
        return redirect(route('products.index'));
    }
}
