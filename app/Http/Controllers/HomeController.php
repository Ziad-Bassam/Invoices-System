<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalcount = Invoice::count();
        $totalsum = Invoice::sum('total');

        $paidcount = Invoice::where('value_status' , 1)->count();
        $paidsum = Invoice::where('value_status' , 1)->sum('total');
        
        $partiallypaidcount = Invoice::where('value_status' , 3)->count();
        $partiallypaidsum = Invoice::where('value_status' , 3)->sum('total');
        
        $unpaidcount = Invoice::where('value_status' ,2)->count();
        $unpaidsum = Invoice::where('value_status' , 2)->sum('total');
        if($paidcount == 0){
            $ratepaid = 0;
        }else{
            $ratepaid = round(($paidcount / $totalcount) * 100 ) ;
        }


        if($partiallypaidcount == 0){
            $ratepartiallypaid = 0;
        }else{
            $ratepartiallypaid = round(($partiallypaidcount / $totalcount) * 100) ;
        }

        if($unpaidcount == 0 ){
            $rateunpaid = 0 ;
        }else{
            $rateunpaid = round(($unpaidcount / $totalcount) * 100 );
        }
            





        
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 150])
            ->labels(['Unpaid invoices', 'Paid invoices' , 'Partially paid invoices'])
            ->datasets([
                [
                    "label" => 'Unpaid invoices',
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$rateunpaid]
                ],
                [
                    "label" => 'Paid invoices',
                    'backgroundColor' => ['#81b214'],
                    'data' => [$ratepaid]
                ],
                [
                    "label" => 'Partially paid invoices',
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$ratepartiallypaid]
                ],


            ])
            ->options([]);


            $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['Unpaid invoices', 'Paid invoices' , 'Partially paid invoices'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$rateunpaid , $ratepaid , $ratepartiallypaid]
                ]
            ])
            ->options([]);

        return view('home' , compact([
            'totalcount' ,
            'totalsum' ,
            'unpaidcount' ,
            'unpaidsum' ,
            'paidcount' ,
            'paidsum' ,
            'partiallypaidsum' ,
            'partiallypaidcount', 
            'ratepaid' ,
            'rateunpaid' ,
            'ratepartiallypaid',
            'chartjs',
            'chartjs_2',
        ]));
    }
}
