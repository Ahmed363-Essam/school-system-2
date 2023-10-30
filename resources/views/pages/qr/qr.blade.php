@extends('layouts.master')
@section('css')

@livewireStyles

@section('title')
    empty
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> QR COD</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">Page Title</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">


                <form method="post" action="{{ route('addQr') }}" autocomplete="off">
                    @csrf


                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>عنوان الحصة : <span class="text-danger">*</span></label>
                                <input class="form-control" name="title" type="text">
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>مدة الحصة بالدقائق : <span class="text-danger">*</span></label>

                                <textarea class="form-control" name="body" id="" cols="900" rows="10"></textarea>
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right"
                        type="submit">{{ trans('Students_trans.submit') }}</button>
                </form>

                @isset($code)
                    <img src="{{ asset('qrcode/'.$code) }}" alt="">
                @endisset
                 


            </div>
        </div>
    </div>
</div>
<!-- row closed -->


             




            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@livewireScripts

@endsection
