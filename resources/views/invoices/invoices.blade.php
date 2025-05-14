@extends('layouts.master')
@section('title')
    Invoices list
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Invoices</h4><span class="text-muted mt-1 tx-16 mr-2 mb-0">/ Invoices
                    list</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')



    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "The invoice has been successfully deleted",
                    type: "error"
                })
            }
        </script>
    @endif




    @if (session()->has('archive_invoices'))
        <script>
            window.onload = function() {
                notif({
                    msg: "The invoice has been successfully archived",
                    type: "warning"
                })
            }
        </script>
    @endif




    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">

                    @can('Add invoice')
                        <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                class="fas fa-plus"></i>&nbsp; Add invoice</a>
                    @endcan

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">invoice_number</th> {{-- رقم الفاتورة --}}
                                    <th class="border-bottom-0">invoice_Date</th> {{-- تاريخ الفاتورة --}}
                                    <th class="border-bottom-0">due_date</th> {{-- تاريخ الاستحقاق --}}
                                    <th class="border-bottom-0">product</th> {{-- المنتج --}}
                                    <th class="border-bottom-0">section</th> {{-- القسم --}}
                                    <th class="border-bottom-0">discount</th> {{-- الخصم --}}
                                    <th class="border-bottom-0">rate_vat</th> {{-- نسبة الضريبة --}}
                                    <th class="border-bottom-0">value_vat</th> {{-- قيمة الضريبة --}}
                                    <th class="border-bottom-0">Total</th> {{-- الاجمالي --}}
                                    <th class="border-bottom-0">Status</th> {{-- حالة الفاتورة --}}
                                    <th class="border-bottom-0">note</th> {{-- ملاحظات --}}
                                    <th class="border-bottom-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($invoices as $invoice)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td><a href="{{ url('InvoicesDetails') }}/{{ $invoice->id }}">
                                                {{ $invoice->section->section_name }}</a>
                                        </td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="text-success">{{ $invoice->status }}</span>
                                            @elseif($invoice->value_status == 2)
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                            @endif

                                        </td>

                                        <td>{{ $invoice->note }}</td>


                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">Actions<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">

                                                    @can('Edit invoice')
                                                        <a class="dropdown-item"
                                                            href=" {{ url('edit_invoice') }}/{{ $invoice->id }}"><i
                                                                class="fas fa-edit"></i>&nbsp;&nbsp;
                                                            Edit invoice</a>
                                                    @endcan


                                                    @can('Delete invoice')
                                                        <a class="dropdown-item" href="#"
                                                            data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                            data-target="#delete_invoice"><i
                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;
                                                            Delete_invoice</a>
                                                    @endcan

                                                    @can('Change payment status')
                                                        <a class="dropdown-item"
                                                            href="{{ URL::route('status_show', [$invoice->id]) }}"><i
                                                                class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp; Change
                                                            of payment status</a>
                                                    @endcan


                                                    @can('Archive the invoice')
                                                        <a class="dropdown-item" href="#"
                                                            data-invoice_id="{{ $invoice->id }}" data-toggle="modal"
                                                            data-target="#Transfer_invoice"><i
                                                                class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;
                                                            Archive invoice</a>
                                                    @endcan

                                                    @can('print invoice')
                                                        <a class="dropdown-item" href="print_invoice/{{ $invoice->id }}"><i
                                                                class="text-success fas fa-print"></i>&nbsp;&nbsp;
                                                            print invoice
                                                        </a>
                                                    @endcan


                                                </div>
                                            </div>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>



    <!--delete invoice-->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ url('invoices/destroy') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body" style="color:red">
                    <h6>
                        <p>?Are you sure about the deletion process</p>
                    </h6>
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--/delete invoice-->




    <!--Archive invoices-->
    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Archive invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    @foreach ($invoices as $invoice)
                        <form action="{{ URL::route('InvoiceArchive', [$invoice->id]) }} }}" method="post">
                    @endforeach
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    ?Are you sure about the archiving process
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--/Archive invoices-->








    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>


    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>


    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

@endsection
