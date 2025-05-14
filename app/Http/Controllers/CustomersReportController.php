<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{


    
    function __construct()
    {

        $this->middleware('permission:reports', ['only' => ['index']]);
        $this->middleware('permission:customer report', ['only' => ['index' , 'search_customers']]);

    }







    public function index(){

        $sections = section::all();
        return view('reports.customers_report',compact('sections'));

    }

    public function search_customers(Request $request){

  // في حالة البحث بدون التاريخ
        
        if ($request->section && $request->product && $request->start_at =='' && $request->end_at=='') {

            $invoices = Invoice::select('*')->where('section_id','=',$request->section)->where('product','=',$request->product)->get();
            $sections = section::all();
            return view('reports.customers_report',compact('sections'))->withDetails($invoices);
    }


    // في حالة البحث بتاريخ
        else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('section_id','=',$request->section)->where('product','=',$request->product)->get();
            $sections = section::all();
            return view('reports.customers_report',compact('sections'))->withDetails($invoices);

        }

    }
}
