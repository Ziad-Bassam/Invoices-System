<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceArchiveController extends Controller
{




    
    function __construct()
    {

        $this->middleware('permission:Archive the invoice', ['only' => ['index']]);
        $this->middleware('permission:Archive the invoice', ['only' => ['create','store']]);
        $this->middleware('permission:Archive the invoice', ['only' => ['edit','update']]);
        $this->middleware('permission:Archive the invoice', ['only' => ['destroy']]);

    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoice::onlyTrashed()->get();
        return view('Invoices.Archive_Invoices', compact('invoices'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        $flight = Invoice::withTrashed()->where('id', $id)->restore();
        session()->flash('edit');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = Invoice::withTrashed()->where('id', $id)->first();
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return back();
    }
}
