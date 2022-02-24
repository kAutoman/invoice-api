@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> {{$is_shop ? 'Shopping List '.$type : 'Parts List '.$type}}
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <button type="button" class="btn btn-sm btn-outline-behance" onclick="$('#hid_mode').val('add');$('#categoryModal').modal('show')"><i class="mdi mdi-plus menu-icon"></i>Add</button>
                    <button type="button" class="btn btn-sm btn-outline-success ml-2" onclick="location.href='{{url('/export_parts')}}'"><i class="mdi mdi-file-excel menu-icon"></i>Export Parts</button>
                    <button type="button" class="btn btn-sm btn-outline-info ml-2" onclick="$('#import_file_btn').click()"><i class="mdi mdi-database-import menu-icon"></i>import Parts</button>
                    <form action="{{url('/import_parts')}}" method="post" enctype="multipart/form-data" id="parts_form">
                        <input type="file" id="import_file_btn" name="file" hidden>
                    </form>
                </ul>
            </nav>
        </div>
        <div class="row">
            <table class="table table-striped table-light">
                <thead>
                <tr>
                    <th scope="col">Q</th>
                    <th scope="col">MQ</th>
                    <th scope="col" class="text-center">Description</th>
                    <th scope="col" class="text-center">PNQ</th>
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
                            <th scope="row">{{$result->q}}</th>
                            <td>{{$result->mq}}</td>
                            <td>{{$result->description}}</td>
                            <td>{{$result->pnq}}</td>
                            <td class="text-center">
                                <input type="hidden" id="record_{{$result->id}}" value='@json($result)'>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="Part.editItem({{$result->id}})"><i class="mdi mdi-pencil menu-icon"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="Part.deleteItem({{$result->id}})"><i class="mdi mdi-trash-can menu-icon"></i></button>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center"> No Data</td>
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
                            <h5 class="modal-title" id="exampleModalLabel">{{$is_shop ? 'Shopping List '.$type : 'Parts List '.$type}} Manage</h5>
                            <a class="close" style="cursor: pointer" onclick="$('#categoryModal').modal('hide')" aria-label="Close">
                                <i class="mdi mdi-close" id="fullscreen-button"></i>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <form id="category_form">
                                    <input type="hidden" name="data[type]" id="hid_type" value="{{$type}}">
                                    <input type="hidden" name="data[is_shopping]" id="hid_is_shop" value="{{$is_shop}}">
                                    <input type="text" class="form-control form-control-md" name="data[q]" id="q" placeholder="Q">
                                    <input type="text" class="form-control form-control-md" name="data[mq]" id="mq" placeholder="MQ">
                                    <input type="text" class="form-control form-control-md" name="data[description]" id="description" placeholder="Description">
                                    <input type="text" class="form-control form-control-md" name="data[pnq]" id="pnq" placeholder="PNQ">
                                    <input type="hidden" class="form-control form-control-md" name="id" id="category_id" value="0">
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#categoryModal').modal('hide')">Close</button>
                            <button type="button" class="btn btn-primary" onclick="Part.saveItem()">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/custom/parts.js')}}"></script>
@endsection
