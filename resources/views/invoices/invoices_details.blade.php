@extends('layouts.master')
@section('title')
    تفاصيل الفاتورة
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفاتورة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a>
                                    </li>
                                    <li><a href="#tab2" class="nav-link" data-toggle="tab">حالة الدفع</a></li>
                                    <li><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="table-responsive mt-15">

                                        <table class="table table-striped" style="text-align:center">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">رقم الفاتورة</th>
                                                    <td>{{ $invoice->invoice_number }}</td>
                                                    <th scope="row">تاريخ الاصدار</th>
                                                    <td>{{ $invoice->invoice_date }}</td>
                                                    <th scope="row">تاريخ الاستحقاق</th>
                                                    <td>{{ $invoice->due_date }}</td>
                                                    <th scope="row">القسم</th>
                                                    <td>{{ $invoice->section->section_name }}</td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">المنتج</th>
                                                    <td>{{ $invoice->product }}</td>
                                                    <th scope="row">مبلغ التحصيل</th>
                                                    <td>{{ $invoice->amount_collection }}</td>
                                                    <th scope="row">مبلغ العمولة</th>
                                                    <td>{{ $invoice->amount_commission }}</td>
                                                    <th scope="row">الخصم</th>
                                                    <td>{{ $invoice->discount }}</td>
                                                </tr>


                                                <tr>
                                                    <th scope="row">نسبة الضريبة</th>
                                                    <td>{{ $invoice->rate_vat }}</td>
                                                    <th scope="row">قيمة الضريبة</th>
                                                    <td>{{ $invoice->value_vat }}</td>
                                                    <th scope="row">الاجمالي مع الضريبة</th>
                                                    <td>{{ $invoice->total }}</td>
                                                    <th scope="row">الحالة الحالية</th>

                                                    @if ($invoice->value_status == 1)
                                                        <td><span
                                                                class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                        </td>
                                                    @elseif($invoice->value_status == 2)
                                                        <td><span
                                                                class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                        </td>
                                                    @else
                                                        <td><span
                                                                class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                                        </td>
                                                    @endif
                                                </tr>

                                                <tr>
                                                    <th scope="row">ملاحظات</th>
                                                    <td>{{ $invoice->note }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <div class="tab-pane" id="tab2">
                                    <div class="table-responsive mt-15">
                                        <table class="table center-aligned-table mb-0 table-hover"
                                            style="text-align:center">
                                            <thead>
                                                <tr class="text-dark">

                                                    <th>رقم الفاتورة</th>
                                                    <th>نوع المنتج</th>
                                                    <th>القسم</th>
                                                    <th>حالة الدفع</th>
                                                    <th>تاريخ الدفع </th>
                                                    <th>ملاحظات</th>
                                                    <th>تاريخ الاضافة </th>
                                                    <th>المستخدم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $invoice->invoice_number }}</td>
                                                    <td>{{ $invoice->product }}</td>
                                                    <td>{{ $invoice->section->section_name }}</td>

                                                    @if ($invoice->value_status == 1)
                                                        <td><span
                                                                class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                        </td>
                                                    @elseif($invoice->value_status == 2)
                                                        <td><span
                                                                class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                        </td>
                                                    @else
                                                        <td><span
                                                                class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                                        </td>
                                                    @endif
                                                    <td>{{ $invoice->payment_date }}</td>
                                                    <td>{{ $invoice->note }}</td>
                                                    <td>{{ $invoice->created_at }}</td>
                                                    <td>{{ $invoice->user }}</td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                                <div class="tab-pane" id="tab3">

                                    <div class="card card-statistics">

                                        <div class="card-body">
                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title">اضافة مرفقات</h5>
                                            <form method="post" action="{{ route('attashments.store') }}"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile"
                                                        name="file_name" required>
                                                    <input type="hidden" id="customFile" name="invoice_number"
                                                        value="{{ $invoice->invoice_number }}">
                                                    <input type="hidden" id="invoice_id" name="invoice_id"
                                                        value="{{ $invoice->id }}">
                                                    <label class="custom-file-label" for="customFile">حدد
                                                        المرفق</label>
                                                </div><br><br>
                                                <button type="submit" class="btn btn-primary btn-sm "
                                                    name="uploadedFile">تاكيد</button>
                                            </form>
                                        </div>

                                        <br>

                                        <div class="table-responsive mt-15">
                                            <table class="table center-aligned-table mb-0 table-hover"
                                                style="text-align:center">
                                                <thead>
                                                    <tr class="text-dark">

                                                        <th>اسم الملف</th>
                                                        <th>قام بالإضافة </th>
                                                        <th>تاريخ الإضافة</th>
                                                        <th>العمليات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($attachments == null)
                                                        <tr>
                                                            <th colspan="4">{{ 'لا يوجد اى مرفقات' }}</th>
                                                        </tr>
                                                    @else
                                                        @foreach ($attachments as $attachment)
                                                            <tr>
                                                                <td>{{ $attachment->file_name }}</td>
                                                                <td>{{ $attachment->created_by }}</td>
                                                                <td>{{ $attachment->created_at }}</td>
                                                                <td colspan="2">

                                                                    <a class="btn btn-outline-success btn-sm"
                                                                        href="{{ url('view_file') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                        role="button"><i class="fas fa-eye"></i>
                                                                        عرض</a>

                                                                    <a class="btn btn-outline-info btn-sm"
                                                                        href="{{ url('download') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                        role="button"><i class="fas fa-download"></i>
                                                                        تحميل</a>
                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        data-toggle="modal"
                                                                        data-file_name="{{ $attachment->file_name }}"
                                                                        data-invoice_number="{{ $attachment->invoice_number }}"
                                                                        data-file_id="{{ $attachment->id }}"
                                                                        data-target="#delete_file"><i
                                                                            class="fas fa-trash"></i>
                                                                        حذف</button>


                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <!-- delete -->
                                            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('delete_file') }}" method="post">

                                                            {{ csrf_field() }}
                                                            <div class="modal-body">
                                                                <p class="text-center">
                                                                <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟
                                                                </h6>
                                                                </p>

                                                                <input type="hidden" name="file_id" id="file_id"
                                                                    value="">
                                                                <input type="hidden" name="file_name" id="file_name"
                                                                    value="">
                                                                <input type="hidden" name="invoice_number"
                                                                    id="invoice_number" value="">

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">الغاء</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">تاكيد</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var file_id = button.data('file_id')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #file_id').val(file_id);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
