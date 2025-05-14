<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Invoice_attachments;
use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\section;
use App\Notifications\AddInvoice;
// use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;


class InvoiceController extends Controller
{


    function __construct()
    {

        $this->middleware('permission:list of invoices', ['only' => ['index']]);
        $this->middleware('permission:invoices', ['only' => ['index']]);
        $this->middleware('permission:Add invoice', ['only' => ['create','store']]);
        $this->middleware('permission:Edit invoice', ['only' => ['edit','update']]);
        $this->middleware('permission:Delete invoice', ['only' => ['destroy']]);
        $this->middleware('permission:paid invoices', ['only' => ['invoices_paid']]);
        $this->middleware('permission:unpaid invoices', ['only' => ['invoices_unpaid']]);
        $this->middleware('permission:Partially paid invoices', ['only' => ['invoices_partial']]);
        $this->middleware('permission:invoice archive', ['only' => ['InvoiceArchive']]);
        $this->middleware('permission:Archive the invoice', ['only' => ['InvoiceArchive']]);
        $this->middleware('permission:print invoice', ['only' => ['print_invoice']]);
        $this->middleware('permission:Change payment status', ['only' => ['status_update','getproducts' ]]);

    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = section::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'amount_collection' => 'required',
            'product' => 'required',
            'amount_commission' => 'required',
            'discount' => 'required',
            'rate_vat' => 'required',
            'value_vat' => 'required',
            'total' => 'required',
            'note' => 'required',
            'section' => 'required',
            'pic' => 'mimes:pdf,jpeg,jpg,png',

        ], [


            'invoice_number.required' => 'Please enter the invoice number',
            'invoice_date.required' => 'Please enter the invoice date',
            'due_date.required' => 'Please enter the due date',
            'amount_collection.required' => 'Please enter the amount collection',
            'product.required' => 'Please enter the product',
            'amount_commission.required' => 'Please enter the amount commission',
            'discount.required' => 'Please enter the discount',
            'rate_vat.required' => 'Please enter the rate vat ',
            'value_vat.required' => 'Please enter the value_vat',
            'total.required' => 'Please enter the total',
            'note.required' => 'Please enter the note',
            'section.required' => 'Please enter the section name',
            'pic.mimes' => 'The attachment format must be: pdf, jpeg ,.jpg , png',

        ]);


        invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'Unpaid',
            'value_status' => 2,
            'note' => $request->note,
        ]);


        $invoice_id = Invoice::latest()->first()->id;

        Invoices_details::create([
            'id_invoice'    => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'Unpaid',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),


        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }



        // ?Notification
        // $user = User::first();
        // // $user->notify(new AddInvoice($invoice_id));
        // Notification::send($user, new AddInvoice($invoice_id));

        $user = User::get();
        $Invoice = Invoice::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice_new($Invoice));


        session()->flash('Add', 'Invoice added successfully');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoices = Invoice::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoices = Invoice::where('id', $id)->first();
        $sections = section::all();
        return view('invoices.edit_invoice', compact(['sections', 'invoices']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $invoices = Invoice::findOrFail($request->invoice_id);



        $validated = $request->validate([
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'amount_collection' => 'required',
            'product' => 'required',
            'amount_commission' => 'required',
            'discount' => 'required',
            'rate_vat' => 'required',
            'value_vat' => 'required',
            'total' => 'required',
            'note' => 'required',
            'section' => 'required',

        ], [


            'invoice_number.required' => 'Please enter the invoice number',
            'invoice_date.required' => 'Please enter the invoice date',
            'due_date.required' => 'Please enter the due date',
            'amount_collection.required' => 'Please enter the amount collection',
            'product.required' => 'Please enter the product',
            'amount_commission.required' => 'Please enter the amount commission',
            'discount.required' => 'Please enter the discount',
            'rate_vat.required' => 'Please enter the rate vat ',
            'value_vat.required' => 'Please enter the value_vat',
            'total.required' => 'Please enter the total',
            'note.required' => 'Please enter the note',
            'section.required' => 'Please enter the section name',


        ]);




        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'section_id' => $request->section,
            'product' => $request->product,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);


        session()->flash('edit', 'Invoice edit successfully');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = Invoice::where('id', $id)->first();
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return back();
        // ! Delete permanently and delete attachment
        // $details = Invoice_attachments::where('invoice_id', $id)->get();
        // if (!empty($details->invoice_number)) {
        //     Storage::disk('public_uploads')->delete($details->invoice_number . '/' . $details->file_name);
        // }


        //soft Delete
        // $invoices->Delete();
    }


    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }

    public function status_update($id, Request $request)
    {
        $invoices = Invoice::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required',
            'payment_date' => 'required',
        ], [
            'status.required' => 'Please enter the status of invoice',
            'payment_date.required' => 'Please enter the payment date of invoice',
        ]);

        if ($request->status == 'paid') {

            $invoices->update([
                'status' => $request->status,
                'value_status' => 1,
                'payment_date' => $request->payment_date,
            ]);
            Invoices_details::create([
                'invoice_number' => $request->invoice_number,
                'id_invoice' => $request->invoice_id,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([

                'status' => $request->status,
                'value_status' => 3,
                'payment_date' => $request->payment_date,
            ]);
            Invoices_details::create([
                'invoice_number' => $request->invoice_number,
                'id_invoice' => $request->invoice_id,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 3,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }

        session()->flash('edit', 'The payment status of the invoice has been modified');
        return redirect('/invoices');
    }



    public function invoices_paid()
    {
        $invoices = Invoice::where('value_status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }


    public function invoices_unpaid()
    {
        $invoices = Invoice::where('value_status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }


    public function invoices_partial()
    {
        $invoices = Invoice::where('value_status', 3)->get();
        return view('invoices.invoices_partial', compact('invoices'));
    }


    public function InvoiceArchive(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = Invoice::where('id', $id)->first();
        //soft Delete
        $invoices->Delete();
        session()->flash('archive_invoices');
        return back();
    }

    public function print_invoice(string $id)
    {
        $invoices = Invoice::where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoices'));
    }




    public function MarkAsRead_all (Request $request)
    {
        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
    }





    public function unreadNotifications_count()
    {
        return auth()->user()->unreadNotifications->count();
    }


    


    public function unreadNotifications()
    {
        foreach (auth()->user()->unreadNotifications as $notification){
        return $notification->data['title'];
        }
    }

}
