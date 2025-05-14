<?php

namespace App\Http\Controllers;

use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{



    
    function __construct()
    {

        $this->middleware('permission:section', ['only' => ['index']]);
        $this->middleware('permission:Add section', ['only' => ['create','store']]);
        $this->middleware('permission:edit section', ['only' => ['edit','update']]);
        $this->middleware('permission:delete section', ['only' => ['destroy']]);

    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::all();
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
        $validated = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required',
        ], [


            'section_name.required' => 'Please enter the section name',
            'section_name.unique' => 'The section name already exists',
            'description.required' => 'Please enter the description',

        ]);

        section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name),
        ]);
        session()->flash('Add', 'The section has been added successfully');
        return redirect('/sections');
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
            'description' => 'required',
        ], [


            'section_name.required' => 'Please enter the section name',
            'section_name.unique' => 'The section name already exists',
            'description.required' => 'Please enter the description',

        ]);

        $section = section::find($id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {
        $id = $request->id;
        section::find($id)->delete();
        session()->flash('delete', 'The section has been deleted');
        return redirect('/sections');
    }
}
