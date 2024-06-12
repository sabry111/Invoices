@extends('layouts.master')
@section('title')
    المنتجات
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
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
    <!-- row -->
    <div class="row">


        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#addproduct">إضافة منتج</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المنتج</th>
                                    <th class="border-bottom-0">اسم القسم</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->section->section_name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td> <a class="modal-effect btn btn-sm btn-primary " data-toggle="modal"
                                                data-id="{{ $product->id }}"
                                                data-product_name="{{ $product->product_name }}"
                                                data-section_name="{{ $product->section->section_name }}"
                                                data-description="{{ $product->description }}" href="#editproduct"><span
                                                    class="fa fa-pen"></span></a>

                                            <a class="modal-effect btn btn-sm btn-danger " data-toggle="modal"
                                                data-id="{{ $product->id }}"
                                                data-product_name="{{ $product->product_name }}"
                                                href="#deleteproduct"><span class="fa fa-trash"></span></a>

                                        </td>
                                    </tr>

                                    {{-- edit --}}
                                    <div class="modal" id="editproduct">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">إضافة قسم</h6><button aria-label="Close"
                                                        class="close" data-dismiss="modal" type="button"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>

                                                <form action="{{ route('products.update', $product->id) }}" method="post">
                                                    @method('Put')
                                                    @csrf
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <input type="hidden" class="form-control" id="id"
                                                                name="id">
                                                            <label for="exampleInputname1" class="form-label"> اسم
                                                                المنتج</label>
                                                            <input type="text" class="form-control" id="product_name"
                                                                name="product_name" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <p class="mg-b-10"> القسم</p>
                                                            <select name="section_name" id="section_name"
                                                                class="form-control " onclick="console.log($(this).val())"
                                                                onchange="console.log('change is firing')">
                                                                <!--placeholder-->
                                                                <option disabled selected>اختر القسم</option>
                                                                @foreach ($sections as $section)
                                                                    <option {{ $section->id }}>
                                                                        {{ $section->section_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1" class="form-label">
                                                                الملاحظات</label>
                                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-primary" type="submit">تعديل</button>
                                                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                                                            type="button">إغلاق</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end of edit --}}


                                    {{-- delete --}}
                                    <div class="modal" id="deleteproduct">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">حذف منتج</h6><button aria-label="Close"
                                                        class="close" data-dismiss="modal" type="button"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>

                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                    method="POST">
                                                    <div class="modal-body">
                                                        @method('delete')
                                                        @csrf
                                                        <div class="form-group">
                                                            <p>هل انت متأكد من حذف :</p>
                                                            <input type="hidden" class="form-control" id="id"
                                                                name="id">
                                                            <input type="text" class="form-control"
                                                                name="product_name" readonly id="product_name">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn ripple btn-secondary" data-dismiss="modal"
                                                                type="button">تراجع</button>
                                                            <button class="btn ripple btn-danger" type="submit">تأكيد
                                                            </button>

                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                    {{-- end of delete --}}
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>



        {{-- add --}}
        <div class="modal" id="addproduct">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">إضافة قسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <form action="{{ route('products.store') }}" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="exampleInputname1" class="form-label">اسم المنتج</label>
                                <input type="text" class="form-control" id="product_name" name="product_name"
                                    required>
                            </div>
                            <div class="mb-4">
                                <p class="mg-b-10">القسم</p>
                                <select name="section_id" id="section_id" class="form-control "
                                    onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    <option disabled selected>اختر القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" class="form-label">الملاحظات</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">إضافة</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end of add --}}




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



    <script>
        $('#editproduct').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_name = button.data('product_name')
            var section_name = button.data('section_name')
            var description = button.data('description')

            var modal = $(this)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #product_name').val(product_name)
            modal.find('.modal-body #section_name').val(section_name)
            modal.find('.modal-body #description').val(description)
        })
    </script>

    <script>
        $('#deleteproduct').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_name = button.data('product_name')

            var modal = $(this)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #product_name').val(product_name)

        })
    </script>
@endsection
