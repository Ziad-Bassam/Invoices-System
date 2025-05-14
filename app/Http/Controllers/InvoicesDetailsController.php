<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachments;
use App\Models\Invoices_details;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{

    // function __construct()
    // {

        
    //     $this->middleware('permission:list of invoices', ['only' => ['index']]);
    //     $this->middleware('permission:Add invoice', ['only' => ['create','store']]);
    //     $this->middleware('permission:Edit invoice', ['only' => ['edit','update']]);
    //     $this->middleware('permission:Delete invoice', ['only' => ['destroy']]);

    // }


    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = Invoice::where('id',$id)->first();
        $details = Invoices_details::where('id_invoice', $id)->get();
        $attachments = Invoice_attachments::where('invoice_id', $id)->get();
        return view('invoices.details_invoice', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'The attachment has been successfully deleted');
        return back();
    }






    // public function get_file($invoice_number, $file_name)

    // {
    //     $contents = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
    //     return response()->download($contents);
    // }



    // public function open_file($invoice_number, $file_name)

    // {
    //     $files = Storage::disk();
    //     return response()->file($files);
    // }
}
