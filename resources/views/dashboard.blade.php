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
@endsection
@section('script')
    <script src="{{asset('assets/custom/dashboard.js')}}"></script>
@endsection
