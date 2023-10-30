@extends('layouts.master')
@section('css')
    @toastr_css

@section('title')
    empty
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> {{ trans('My_Classes_trans.title_page') }}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active"> {{ trans('My_Classes_trans.title_page') }}</li>
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card card-statistics h-100">
            <div class="card-body">
                <p>Page content goes here<br> <br> </p>



                <!-- main body -->
                <div class="row">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">





                                <button type="button" class="button x-small" data-toggle="modal"
                                    data-target="#exampleModal">
                                    {{ trans('My_Classes_trans.add_class') }}
                                </button>


                                <button type="button" class="button x-small" id="btn_delete_all">
                                    {{ trans('My_Classes_trans.delete_checkbox') }}
                                </button>



                                <br><br>

                                <form action="{{ route('Filter_Classes') }}" method="POST">
                                    {{ csrf_field() }}
                                    <select class="selectpicker" data-style="btn-info" name="Grade_id" required
                                        onchange="this.form.submit()">
                                        <option value="" selected disabled>
                                            {{ trans('My_Classes_trans.Search_By_Grade') }}</option>
                                        @foreach ($grades as $Grade)
                                            <option value="{{ $Grade->id }}">{{ $Grade->Name }}</option>
                                        @endforeach
                                    </select>
                                </form>




                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered p-0">
                                        <thead>
                                            <tr>
                                                <th><input name="select_all" id="example-select-all" type="checkbox"
                                                        onclick="CheckAll('box1', this)" /></th>
                                                <th> # </th>
                                                <th> {{ trans('My_Classes_trans.Name_class_en') }}</th>
                                                <th> {{ trans('My_Classes_trans.Name_Grade') }}</th>
                                                <th> {{ trans('My_Classes_trans.Processes') }}</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            @if (isset($details))
                                                <?php $List_Classes = $details; ?>
                                            @else
                                                <?php $List_Classes = $Classrooms; ?>
                                            @endif



                                            <?php $i = 0; ?>
                                            @foreach ($List_Classes as $Classroom)
                                                <?php $i++; ?>
                                                <tr>
                                                    <td><input type="checkbox" value="{{ $Classroom->id }}"
                                                            class="box1"></td>
                                                    <td> {{ $i }} </td>
                                                    <td> {{ $Classroom->Name_Class }} </td>
                                                    <td> {{ $Classroom->Grades->Name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-toggle="modal" data-target="#edit{{ $Classroom->id }}"
                                                            title="{{ trans('Grade_trans.Edit') }}"><i
                                                                class="fa fa-edit"></i></button>


                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#delete{{ $Classroom->id }}"
                                                            title="{{ trans('Grade_trans.Delete') }}"><i
                                                                class="fa fa-trash"></i></button>
                                                    </td>

                                                </tr>






                                                <!-- edit_modal_Grade -->
                                                <div class="modal fade" id="edit{{ $Classroom->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;"
                                                                    class="modal-title" id="exampleModalLabel">
                                                                    {{ trans('My_Classes_trans.edit_class') }}
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- edit_form -->
                                                                <form action="{{ route('classes.update', 'test') }}"
                                                                    method="post">
                                                                    {{ method_field('patch') }}
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <label for="Name"
                                                                                class="mr-sm-2">{{ trans('My_Classes_trans.Name_class') }}
                                                                                :</label>
                                                                            <input id="Name" type="text"
                                                                                name="Name" class="form-control"
                                                                                value="{{ $Classroom->getTranslation('Name_Class', 'ar') }}"
                                                                                required>
                                                                            <input id="id" type="hidden"
                                                                                name="id" class="form-control"
                                                                                value="{{ $Classroom->id }}">
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="Name_en"
                                                                                class="mr-sm-2">{{ trans('My_Classes_trans.Name_class_en') }}
                                                                                :</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $Classroom->getTranslation('Name_Class', 'en') }}"
                                                                                name="Name_en" required>
                                                                        </div>
                                                                    </div><br>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="exampleFormControlTextarea1">{{ trans('My_Classes_trans.Name_Grade') }}
                                                                            :</label>
                                                                        <select class="form-control form-control-lg"
                                                                            id="exampleFormControlSelect1"
                                                                            name="Grade_id">
                                                                            <option
                                                                                value="{{ $Classroom->Grades->id }}">
                                                                                {{ $Classroom->Grades->Name }}
                                                                            </option>
                                                                            @foreach ($grades as $Grade)
                                                                                <option value="{{ $Grade->id }}">
                                                                                    {{ $Grade->Name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                    <br><br>

                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>





                                                <!-- delete_modal_Grade -->
                                                <div class="modal fade" id="delete{{ $Classroom->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="font-family: 'Cairo', sans-serif;"
                                                                    class="modal-title" id="exampleModalLabel">
                                                                    {{ trans('My_Classes_trans.delete_class') }}
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('classes.destroy', 'test') }}"
                                                                    method="post">
                                                                    {{ method_field('Delete') }}
                                                                    @csrf
                                                                    {{ trans('My_Classes_trans.Warning_Grade') }}
                                                                    <input id="id" type="hidden"
                                                                        name="id" class="form-control"
                                                                        value="{{ $Classroom->id }}">
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-dismiss="modal">{{ trans('My_Classes_trans.Close') }}</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">{{ trans('My_Classes_trans.submit') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach





                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>







                    <!-- add_modal_class -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                        id="exampleModalLabel">
                                        {{ trans('My_Classes_trans.add_class') }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form class=" row mb-30" action="{{ route('classes.store') }}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="repeater">
                                                <div data-repeater-list="List_Classes1">
                                                    <div data-repeater-item>
                                                        <div class="row">

                                                            <div class="col">
                                                                <label for="Name"
                                                                    class="mr-sm-2">{{ trans('My_Classes_trans.Name_class') }}
                                                                    :</label>
                                                                <input class="form-control" type="text"
                                                                    name="Name" />
                                                            </div>


                                                            <div class="col">
                                                                <label for="Name"
                                                                    class="mr-sm-2">{{ trans('My_Classes_trans.Name_class_en') }}
                                                                    :</label>
                                                                <input class="form-control" type="text"
                                                                    name="Name_class_en" />
                                                            </div>


                                                            <div class="col">
                                                                <label for="Name_en"
                                                                    class="mr-sm-2">{{ trans('My_Classes_trans.Name_Grade') }}
                                                                    :</label>

                                                                <div class="box">
                                                                    <select class="fancyselect" name="Grade_id">
                                                                        @foreach ($grades as $grades)
                                                                            <option value="{{ $grades->id }}">
                                                                                {{ $grades->Name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>

                                                            <div class="col">
                                                                <label for="Name_en"
                                                                    class="mr-sm-2">{{ trans('My_Classes_trans.Processes') }}
                                                                    :</label>
                                                                <input class="btn btn-danger btn-block"
                                                                    data-repeater-delete type="button"
                                                                    value="{{ trans('My_Classes_trans.delete_row') }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-20">
                                                    <div class="col-12">
                                                        <input class="button" data-repeater-create type="button"
                                                            value="{{ trans('My_Classes_trans.add_row') }}" />
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{ trans('Grade_trans.Close') }}</button>
                                                    <button type="submit"
                                                        class="btn btn-success">{{ trans('Grade_trans.submit') }}</button>
                                                </div>


                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>

                        </div>








                        <!-- حذف مجموعة صفوف -->
                        <div class="modal fade" id="delete_all" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                            id="exampleModalLabel">
                                            {{ trans('My_Classes_trans.delete_class') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{ route('delete_all') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            {{ trans('My_Classes_trans.Warning_Grade') }}
                                            <input class="text" type="hidden" id="delete_all_id"
                                                name="delete_all_id" value=''>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ trans('My_Classes_trans.Close') }}</button>
                                            <button type="submit"
                                                class="btn btn-danger">{{ trans('My_Classes_trans.submit') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>










            </div>

            <!--=================================


            </div>
        </div>
    </div>
</div>
<!-- row closed -->
        @endsection
        @section('js')
            @toastr_js
            @toastr_render
            <script type="text/javascript">
                $(function() {
                    $("#btn_delete_all").click(function() {
                        var selected = new Array();
                        $("#datatable input[type=checkbox]:checked").each(function() {
                            selected.push(this.value);
                        });
                        if (selected.length > 0) {
                            $('#delete_all').modal('show')
                            $('input[id="delete_all_id"]').val(selected);
                        }
                    });
                });
            </script>

        @endsection
