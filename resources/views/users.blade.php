@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Users
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <button type="button" class="btn btn-sm btn-outline-behance" onclick="$('#hid_mode').val('add');$('#userModal').modal('show')"><i class="mdi mdi-plus menu-icon"></i>Add</button>
                    <button type="button" class="btn btn-sm btn-outline-danger ml-2" onclick="batchDelete('users')"><i class="mdi mdi-delete-restore menu-icon"></i>Batch</button>
                </ul>
            </nav>
        </div>
        <div class="row">
            <table class="table table-striped table-light">
                <thead>
                <tr>
                    <th scope="col">
                        <input class="form-check-input" type="checkbox" value="" onchange="toggleCheckBox(this)" aria-label="...">
                    </th>
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
                            <td>
                                <input class="form-check-input" type="checkbox" value="{{$result->id}}" aria-label="...">
                            </td>
                            <th scope="row">{{$i}}</th>
                            <td>{{$result->email}}</td>
                            <td class="text-center">
                                <input type="hidden" id="record_{{$result->id}}" value='@json($result)'>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="Users.editItem({{$result->id}})"><i class="mdi mdi-pencil menu-icon"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="Users.deleteItem({{$result->id}})"><i class="mdi mdi-trash-can menu-icon"></i></button>
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
            <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">User Manage</h5>
                            <a class="close" style="cursor: pointer" onclick="$('#userModal').modal('hide')" aria-label="Close">
                                <i class="mdi mdi-close" id="fullscreen-button"></i>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <form id="user_form">
                                    <input type="text" class="form-control form-control-md" name="data[email]" id="user_name" placeholder="Please enter user name here.">
                                    <input type="text" class="form-control form-control-md" name="data[password]" id="user_password" placeholder="Please enter password here.">
                                    <input type="hidden" class="form-control form-control-md" name="id" id="user_id" value="0">
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#userModal').modal('hide')">Close</button>
                            <button type="button" class="btn btn-primary" onclick="Users.insertUser()">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/custom/users.js')}}"></script>
@endsection
