@extends('layouts.master')
@section('title')
    Invoices Details
@stop
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Invoice</h4><span class="text-muted mt-1 tx-16 mr-2 mb-0">/ Invoices
                    Details</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')




    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif







    <!-- div -->
    <div class="card" id="tabs-style4">
        <div class="card-body">
            <div class="main-content-label mg-b-5">Invoice information
            </div>
            <div class="text-wrap">
                <div class="example">
                    <div class="d-md-flex">
                        <div class="">
                            <div class="panel panel-primary tabs-style-4">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu ">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs ml-3">
                                            <li class=""><a href="#tab21" class="active" data-toggle="tab">Invoice
                                                    information</a></li>
                                            <li><a href="#tab22" data-toggle="tab">Payment
                                                    statuses</a></li>
                                            <li><a href="#tab23" data-toggle="tab">Attachments</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tabs-style-4 ">
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content">

                                    <!--Invoice information-->

                                    <div class="tab-pane active" id="tab21">

                                        <table class="table table-striped" style="text-align:center">


                                            <tr>
                                                <th scope="row">Invoice number</th>
                                                <td>{{ $invoices->invoice_number }}</td>
                                                <th scope="row">Invoice date</th>
                                                <td>{{ $invoices->invoice_date }}</td>
                                                <th scope="row">Due date</th>
                                                <td>{{ $invoices->due_date }}</td>
                                                <th scope="row">Section</th>
                                                <td>{{ $invoices->section->section_name }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Product</th>
                                                <td>{{ $invoices->product }}</td>
                                                <th scope="row">Amount collection</th>
                                                <td>{{ $invoices->amount_collection }}</td>
                                                <th scope="row">Amount commission</th>
                                                <td>{{ $invoices->amount_commission }}</td>
                                                <th scope="row">Discount</th>
                                                <td>{{ $invoices->discount }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Rate VAT</th>
                                                <td>{{ $invoices->rate_vat }}</td>
                                                <th scope="row">Value_VAT</th>
                                                <td>{{ $invoices->value_vat }}</td>
                                                <th scope="row">Total</th>
                                                <td>{{ $invoices->total }}</td>
                                                <th scope="row">Current status</th>

                                                @if ($invoices->value_status == 1)
                                                    <td><span
                                                            class="badge badge-pill badge-success">{{ $invoices->status }}</span>
                                                    </td>
                                                @elseif($invoices->value_status == 2)
                                                    <td><span
                                                            class="badge badge-pill badge-danger">{{ $invoices->status }}</span>
                                                    </td>
                                                @else
                                                    <td><span
                                                            class="badge badge-pill badge-warning">{{ $invoices->status }}</span>
                                                    </td>
                                                @endif
                                            </tr>

                                            <tr>
                                                <th scope="row">Note</th>
                                                <td>{{ $invoices->note }}</td>

                                            </tr>

                                        </table>
                                    </div>
                                    <!--/Invoice information-->



                                    <!--Payment statuses -->
                                    <div class="tab-pane" id="tab22">
                                        <table class="table center-aligned-table mb-0 table-hover"
                                            style="text-align:center">
                                            <thead>
                                                <tr class="text-dark">
                                                    <th>#</th>
                                                    <th>Invoice number</th>
                                                    <th>Product</th>
                                                    <th>Section</th>
                                                    <th>Payment status</th>
                                                    <th>Payment history</th>
                                                    <th>note</th>
                                                    <th>Date added</th>
                                                    <th>User</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($details as $detail)
                                                    <?php $i++; ?>
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $detail->invoice_number }}</td>
                                                        <td>{{ $detail->product }}</td>
                                                        <td>{{ $invoices->section->section_name }}</td>
                                                        @if ($detail->value_status == 1)
                                                            <td><span
                                                                    class="badge badge-pill badge-success">{{ $detail->status }}</span>
                                                            </td>
                                                        @elseif($detail->value_status == 2)
                                                            <td><span
                                                                    class="badge badge-pill badge-danger">{{ $detail->status }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class="badge badge-pill badge-warning">{{ $detail->status }}</span>
                                                            </td>
                                                        @endif
                                                        <td>{{ $detail->payment_date }}</td>
                                                        <td>{{ $detail->note }}</td>
                                                        <td>{{ $detail->created_at }}</td>
                                                        <td>{{ $detail->user }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--/Payment statuses -->





                                    <!--Attachments-->
                                    <div class="tab-pane" id="tab23">
                                        <div class="card card-statistics ">

                                            @can('Add attachment')
                                                <div class="card-body">
                                                    <p class="text-danger">* Attachment format : pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">Add attachments</h5>
                                                    <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                        enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="customFile"
                                                                name="file_name" required>
                                                            <input type="hidden" id="customFile" name="invoice_number"
                                                                value="{{ $invoices->invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                value="{{ $invoices->id }}">
                                                            <label class="custom-file-label" for="customFile">Select the
                                                                attachment</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm "
                                                            name="uploadedFile">Submit</button>
                                                    </form>
                                                </div>
                                            @endcan

                                            <br>
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table table-hover"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th scope="col">#
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </th>
                                                            <th scope="col">File name
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </th>
                                                            <th scope="col">User
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </th>
                                                            <th scope="col">Date added
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </th>
                                                            <th scope="col">Actions
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($attachments as $attachment)
                                                            <?php $i++; ?>
                                                            <tr>

                                                                <td>{{ $i }}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </td>
                                                                <td>{{ $attachment->file_name }}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </td>
                                                                <td>{{ $attachment->Created_by }}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </td>
                                                                <td>{{ $attachment->created_at }}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </td>
                                                                <td colspan="2">
                                                                    {{-- !show --}}
                                                                    {{-- <a class="btn btn-outline-success btn-sm"
                                                                        href="{{ url('view_file') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                        Show</a> --}}


                                                                    {{-- !download --}}
                                                                    {{-- <a class="btn btn-outline-info btn-sm"
                                                                        href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                        role="button"><i
                                                                            class="fas fa-download"></i>&nbsp;
                                                                        Download</a> --}}

                                                                    @can('Delete attachment')
                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            data-toggle="modal"
                                                                            data-file_name="{{ $attachment->file_name }}"
                                                                            data-invoice_number="{{ $attachment->invoice_number }}"
                                                                            data-id_file="{{ $attachment->id }}"
                                                                            data-target="#delete_file">Delete
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                                                    @endcan
                                                                    
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <!--/Attachments-->




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete attachment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_file') }}" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red">Are you sure you want to delete the attachment?</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->




@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>


    {{-- delete --}}
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
