@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@section('title')
    تعديل الصلاحيات 
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                الصلاحيات</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>خطا</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<form action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-group">
                                <p>اسم الصلاحية :</p>
                                <input type="text" class="form-control" name="name" value="{{ $role->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- col -->
                        <div class="col-lg-4">
                            <ul id="treeview1">
                                <li><a href="#">الصلاحيات</a>
                                    <ul>
                                </li>

                                {{-- @foreach ($permission as $value)
                                    <div>
                                        <label><input name="permission[]" type="checkbox" value="{{ $value->name }}">
                                            {{ $value->name }} </label>
                                    </div>
                                @endforeach --}}


                                @foreach ($permission as $value)
                                    <div>

                                        <label class="m-3"><input type="checkbox"
                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}
                                                name="permission[]"
                                                value="{{ $value->name }}">{{ $value->name }}</label>
                                    </div>
                                @endforeach


                            </ul>

                        </div>
                        <!-- /col -->
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-main-primary">تحديث</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- row closed -->
</form>
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->

@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
@endsection
