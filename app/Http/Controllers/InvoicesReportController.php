<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;


class InvoicesReportController extends Controller
{




     
    function __construct()
    {

        $this->middleware('permission:reports', ['only' => ['index']]);
        $this->middleware('permission:invoices report', ['only' => ['index' , 'search_invoices']]);

    }





    public function index()
    {
        return view('reports.invoices_report');
    }




    

    public function search_invoices(Request $request)
    {
        $rdio = $request->rdio;

        // If you search by invoice type

        if ($rdio == 1) {
            // If no date is selected
            if ($request->type && $request->start_at == '' && $request->end_at == '') {
                $invoices = Invoice::select('*')->where('status', '=', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('type'))->withDetails($invoices);
            }

            // If you specify a due date
            else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = Invoice::whereBetween('invoice_Date', [$start_at, $end_at])
                    ->where('status', '=', $request->type)
                    ->get();
                    dd($invoices);

                return view('reports.invoices_report', compact('type', 'start_at', 'end_at'))->withDetails($invoices);
            }
        }

        //====================================================================
        //  If you search by invoice number
        else {
            $invoices = Invoice::select('*')->where('invoice_number', '=', $request->invoice_number)->get();
            return view('reports.invoices_report')->withDetails($invoices);
        }
    }
}

