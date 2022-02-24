@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Categories
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <button type="button" class="btn btn-sm btn-outline-behance" onclick="$('#hid_mode').val('add');$('#categoryModal').modal('show')"><i class="mdi mdi-plus menu-icon"></i>Add</button>
                    <button type="button" class="btn btn-sm btn-outline-success ml-2" onclick="location.href='{{url('/export_categories')}}'"><i class="mdi mdi-file-excel menu-icon"></i>Export Categories</button>
                    <button type="button" class="btn btn-sm btn-outline-info ml-2" onclick="$('#import_file_btn').click()"><i class="mdi mdi-database-import menu-icon"></i>import Categories</button>
                    <form action="{{url('/import_categories')}}" method="post" enctype="multipart/form-data" id="categories_form">
                        <input type="file" id="import_file_btn" name="file" hidden>
                    </form>
                </ul>
            </nav>
        </div>
        <div class="row">
            <table class="table table-striped table-light">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col" class="text-center">Control</th>
                </tr>
                </thead>
                <tbody>
                @if(count($results) > 0)
                    @php
                        $i=1;
                    @endphp
                    @foreach($results as $result)
                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$result->name}}</td>
                            <td class="text-center">
                                <input type="hidden" id="record_{{$result->id}}" value='@json($result)'>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="Category.editItem({{$result->id}})"><i class="mdi mdi-pencil menu-icon"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="Category.deleteItem({{$result->id}})"><i class="mdi mdi-trash-can menu-icon"></i></button>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center"> No Data</td>
                    </tr>
                @endif
                </tbody>
            </table>

            <input type="hidden" id="hid_mode" value="add">

            <!-- add Modal -->
            <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Category Manage</h5>
                            <a class="close" style="cursor: pointer" onclick="$('#categoryModal').modal('hide')" aria-label="Close">
                                <i class="mdi mdi-close" id="fullscreen-button"></i>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <form id="category_form">
                                    <input type="text" class="form-control form-control-md" name="data[name]" id="category_name" placeholder="Please enter category name here.">
                                    <input type="hidden" class="form-control form-control-md" name="id" id="category_id" value="0">
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#categoryModal').modal('hide')">Close</button>
                            <button type="button" class="btn btn-primary" onclick="Category.insertCategory()">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/custom/categories.js')}}"></script>
@endsection
