@extends('layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Customers
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <button type="button" class="btn btn-sm btn-outline-behance"><i class="mdi mdi-plus menu-icon"></i>Add</button>
                </ul>
            </nav>
        </div>
        <div class="row">
            <table class="table table-striped table-light">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mobile Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Created At</th>
                    <th scope="col" class="text-center">Control</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-success"><i class="mdi mdi-pencil menu-icon"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger"><i class="mdi mdi-trash-can menu-icon"></i></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
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
@endsection
@section('script')
    <script src="{{asset('assets/custom/customers.js')}}"></script>
@endsection
