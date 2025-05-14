@extends('layouts.master')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('title')
    Preview the invoice print
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">invoices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Preview the invoice print</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title" style="color: rgb(0, 104, 35)">Collection invoice</h1>
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="invoice-title" style="color: rgb(10, 0, 104)">
                                    <h3>Invoice information</h3>
                                </label>
                            </div>
                            <div class="col-md">
                                <p class="invoice-info-row"><span>Invoice number</span>
                                    <span>{{ $invoices->invoice_number }}</span>
                                </p>
                                <p class="invoice-info-row"><span>Invoice date</span>
                                    <span>{{ $invoices->invoice_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>Due date</span>
                                    <span>{{ $invoices->due_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>Section name</span>
                                    <span>{{ $invoices->section->section_name }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p">product</th>
                                        <th class="tx-center">Amount collection</th>
                                        <th class="tx-right">Amount commission</th>
                                        <th class="tx-right">total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="tx-12">{{ $invoices->product }}</td>
                                        <td class="tx-center">{{ number_format($invoices->amount_collection, 2) }}</td>
                                        <td class="tx-right">{{ number_format($invoices->amount_commission, 2) }}</td>
                                        @php
                                            $total = $invoices->amount_collection + $invoices->amount_commission;
                                        @endphp
                                        <td class="tx-right">
                                            {{ number_format($total, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="valign-middle" colspan="2" rowspan="4">
                                            <div class="invoice-notes">
                                                <label class="main-content-label tx-13">#</label>

                                            </div><!-- invoice-notes -->
                                        </td>
                                        <td class="tx-right">total</td>
                                        <td class="tx-right" colspan="2"> {{ number_format($total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">Rate_VAT ({{ $invoices->rate_vat }})</td>
                                        <td class="tx-right" colspan="2">287.50</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">Discount</td>
                                        <td class="tx-right" colspan="2"> {{ number_format($invoices->discount, 2) }}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">Total includes tax</td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-primary tx-bold">{{ number_format($invoices->total, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">



                        <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                                class="mdi mdi-printer ml-1"></i>Print</button>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>


    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>

@endsection
