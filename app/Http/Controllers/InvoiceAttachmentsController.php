<?php

namespace App\Http\Controllers;

use App\Models\Invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentsController extends Controller
{



    function __construct()
    {

        
        //$this->middleware('permission:list of invoices', ['only' => ['index']]);
        $this->middleware('permission:Add attachment', ['only' => ['create','store']]);
        // $this->middleware('permission:Edit invoice', ['only' => ['edit','update']]);
        $this->middleware('permission:Delete attachment', ['only' => ['destroy']]);

    }


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
        $this->validate($request, [
            'file_name' => 'mimes:pdf,jpeg,jpg,png',
        ], [
            'file_name.mimes' => 'The attachment format must be: pdf, jpeg ,.jpg , png',
        ]);

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $attachments =  new invoice_attachments();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->Created_by = Auth::user()->name;
        $attachments->save();


        //move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imageName);

        session()->flash('Add', 'The attachment has been added successfully');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice_attachments $invoice_attachments)
    {
        //
    }
}
