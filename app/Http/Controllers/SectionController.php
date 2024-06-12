<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{



    public function __construct()
    {

        $this->middleware('permission:الاقسام', ['only' => ['index']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['store']]);
        $this->middleware('permission:تعديل قسم', ['only' => [ 'update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.sections', compact('sections'));
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
        // dd($request->all());
        $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name',

        ],
            [
                'section_name.required' => 'يرجى إدخال اسم القسم',
                'section_name.unique' => 'اسم القسم موجود بالفعل',
            ]);

        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (auth()->user()->name),
        ]);
        return redirect(route('sections.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());

        $id = $request->id;
        $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
        ],
            [
                'section_name.required' => 'يرجى إدخال اسم القسم',
                'section_name.unique' => 'اسم القسم موجود بالفعل',
            ]);

        $section = Section::find($id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        return redirect(route('sections.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $section = Section::find($id);
        $section->delete();
        return redirect(route('sections.index'));
    }
}
