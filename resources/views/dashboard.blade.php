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
                    <button type="button" class="btn btn-sm btn-outline-behance" onclick="Dashboard.addCustomer()"><i class="mdi mdi-plus menu-icon"></i>Add</button>
                    <button type="button" class="btn btn-sm btn-outline-success ml-2" onclick="location.href='{{url('/export_customers')}}'"><i class="mdi mdi-file-excel menu-icon"></i>Export Customer</button>
                    <button type="button" class="btn btn-sm btn-outline-success ml-2" onclick="location.href='{{url('/export_invoices')}}'"><i class="mdi mdi-file-excel menu-icon"></i>Export invoices</button>
                    <form action="{{url('/import_customers')}}" method="post" enctype="multipart/form-data" id="customer_csv_form">
                        <input type="file" id="import_file_btn" name="file" hidden>
                    </form>
                    <form action="{{url('/import_invoices')}}" method="post" enctype="multipart/form-data" id="invoice_csv_form">
                        <input type="file" id="import_invoice_btn" name="file" hidden>
                    </form>
                    <button type="button" class="btn btn-sm btn-outline-info ml-2" onclick="$('#import_file_btn').click()"><i class="mdi mdi-database-import menu-icon"></i>import Customer</button>
                    <button type="button" class="btn btn-sm btn-outline-info ml-2" onclick="$('#import_invoice_btn').click()"><i class="mdi mdi-database-import menu-icon"></i>import Invoices</button>
                </ul>
            </nav>
        </div>
        <div class="page-header">
            <h3 class="page-title">
                <div class="form-inline">
                    <form action="{{url('/dashboard')}}" method="post" id="search_form">
                        <input type="text" class="form-control" id="search_customer" placeholder="Search Title" name="search[title]" value="{{$search['title']?? ''}}">
                        <select name="search[state]" id="search_status" class="form-control ml-2">
                            <option value="">select status</option>
                            <option value="1" {{!empty($search['state'])&&$search['state'] == '1' ? 'selected':''}}>active</option>
                            <option value="2" {{!empty($search['state'])&&$search['state'] == '2' ? 'selected':''}}>complete</option>
                            <option value="3" {{!empty($search['state'])&&$search['state'] == '3' ? 'selected':''}}>waiting</option>
                        </select>
                        <select name="search[category]" id="search_category" class="form-control ml-2">
                            <option value="">select category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{!empty($search['category'])&&$search['category'] == $category->id ? 'selected':''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control date-picker" style="width: 200px" id="search_date_from" placeholder="Date From" name="search[date_from]" value="{{$search['date_from']?? ''}}">
                        <input type="text" class="form-control date-picker" style="width: 200px" id="search_date_to" placeholder="Date To" name="search[date_to]" value="{{$search['date_to']?? ''}}">
                    </form>
                </div>
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <button type="button" class="btn btn-sm btn-outline-behance" onclick="$('#search_form').submit()"><i class="mdi mdi-search-web menu-icon"></i>Search</button>
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
                    <th scope="col">title</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mobile Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Created At</th>
                    <th scope="col" class="text-center">Control</th>
                </tr>
                </thead>
                <tbody>
                    @if(count($results) > 0)
                        @foreach($results as $key=>$result)
                            <tr>
                                <td>
                                    <input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="" aria-label="...">
                                </td>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$result->title}}</td>
                                <td>{{$result->email}}</td>
                                <td>{{$result->mobile_phone}}</td>
                                <td>{{$result->name}}</td>
                                <td>{{$result->created_at}}</td>
                                <td class="text-center">
                                    <input type="hidden" id='customer_{{$result->id}}' value="@json($result)">
                                    <button type="button" class="btn btn-sm btn-outline-success" title="Edit" onclick="Dashboard.editCustomer({{$result->id}})"><i class="mdi mdi-pencil menu-icon"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-info" title="Export Invoice to PDF" onclick="Dashboard.getInvoiceList({{$result->id}})"><i class="mdi mdi-file-pdf-outline menu-icon"></i></button>

                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="Dashboard.deleteCustomer({{$result->id}})"><i class="mdi mdi-trash-can menu-icon"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center"> No Data</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="categoryModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Manage</h5>
                    <a class="close" style="cursor: pointer" onclick="$('#categoryModal').modal('hide')" aria-label="Close">
                        <i class="mdi mdi-close" id="fullscreen-button"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form id="customer_form">
                            <div class="form-group">
                                <textarea name="data[title]" id="title" cols="30" rows="10" class="form-control form-control-md" placeholder="Title for tasks list..."></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[mobile_phone]" id="mobile_phone" placeholder="Mobile number">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[email]" id="customer_email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[name]" id="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[address]" id="address" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[town]" id="town" placeholder="Town">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[postal_code]" id="postal_code" placeholder="Postal Code">
                            </div>
                            <div class="form-group"><input type="text" class="form-control form-control-md" name="data[created_at]" id="created_at" readonly placeholder="Date form created" value="{{date('Y-m-d H:i:s')}}"></div>
                            <div class="form-group"><input type="text" class="form-control form-control-md" name="data[updated_at]" id="updated_at" readonly placeholder="Date form updated" value=""></div>
                            <div class="form-group">
                                <input type="datetime-local" class="form-control form-control-md" autocomplete="off" name="data[remind_date]" id="remind_date" placeholder="remind date">
                            </div>
                            <div class="form-group">
                                <textarea name="data[further_note]" id="further_note" cols="30" rows="10" class="form-control form-control-md" placeholder="Further note"></textarea>
                            </div>
                            <div class="form-group">
                                 <select name="data[sms_sent]" id="sms_sent" class="form-control-sm w-100">
                                    <option value="">Select SMS Status</option>
                                    <option value="1">Sent</option>
                                    <option value="0">Not sent</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="data[state]" id="state" class="form-control-sm w-100">
                                    <option value="">Select state</option>
                                    <option value="1">Active</option>
                                    <option value="2">Completed</option>
                                    <option value="3">Waiting</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="data[category_id]" id="category" class="form-control-sm w-100">
                                    <option value=''>select category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="data[attached_files]" id="hid_attached_files" value="[]">
                            <input type="hidden" name="mode" id="hid_mode" value="add">
                            <input type="hidden" class="form-control form-control-md" name="id" id="customer_id" value="0">
                            <div class="form-group">
                                <div class="dropzone dz-clickable" id="my-dropzone">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-gradient-info" onclick="Dashboard.addInvoice()"> ADD INVOICE</button>
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Invoice No</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice_body">
                                        <tr id="invoice_nodata">
                                            <td colspan="2" class="text-center" >No Data</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#categoryModal').modal('hide')">Close</button>
                    <button type="button" class="btn btn-primary" onclick="Dashboard.saveCustomer()">Save Customer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- invoice Modal -->
    <div class="modal fade" id="invoiceModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">invoice</h5>
                    <a class="close" style="cursor: pointer" onclick="$('#invoiceModal').modal('hide');$('#categoryModal').modal('show');" aria-label="Close">
                        <i class="mdi mdi-close" id="fullscreen-button"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form id="invoice_form">
                            <div class="form-group text-center">
                                <div class="mb-2">
                                    <label for="Image" class="form-label">Preset 1</label>
                                    <input class="form-control" type="file" id="formFile" name="preset1" onchange="Dashboard.preview1()" accept="image/jpg, image/jpeg">
                                </div>
                                <img id="frame1" src="{{asset('/assets/images/logo.jpg')}}" class="img-fluid" width="300" height="300"/>
                            </div>
                            <div class="form-group text-center">
                                <div class="mb-2">
                                    <label for="Image" class="form-label">Preset 2</label>
                                    <input class="form-control" type="file" id="formFile" name="preset2" onchange="Dashboard.preview2()" accept="image/jpg, image/jpeg" >
                                </div>
                                <img id="frame2" src="{{asset('/assets/images/logo2.jpg')}}" class="img-fluid" width="300" height="300"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[invoice_no]" id="invoice_no" placeholder="invoice No">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[email]" id="invoice_email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="datetime-local" class="form-control form-control-md" name="data[invoice_date]" id="invoice_date" placeholder="invoice Date">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[mobile_num]" id="invoice_mobile_num"  placeholder="Mobile Number">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[to]" id="invoice_to" placeholder="to">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[from_address]" id="invoice_from_addr" placeholder="from address">
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="hid_invoice_items" name="data[items]" value="[]">
                                <input type="hidden" id="hid_invoice_mode" name="mode" value="add">
                                <input type="hidden" id="hid_invoice_id" name="id" value="0">
                                <input type="hidden" id="hid_customer_id" name="data[customer_id]" value="0">
                                <button type="button" class="btn btn-gradient-info" onclick="Dashboard.addInvoiceItem()"> ADD INVOICE ITEM</button>
                            </div>
                            <div class="form-group">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice_item_body">
                                      <tr>
                                          <td colspan="4" class="text-center">No data</td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group"><input type="text" class="form-control form-control-md" name="data[excluding_vat]" id="excluding_vat" placeholder="excluding vat"></div>
                            <div class="form-group"><input type="text" class="form-control form-control-md" name="data[vat_amount]" id="vat_amount" placeholder="vat amount"></div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[invoice_total]" id="invoice_total" placeholder="invoice total">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[payed_amount]" id="payed_amount" placeholder="payed amount">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[due_total]" id="due_total" placeholder="due total">
                            </div>
                            <div class="form-group">
                                <textarea rows="5" class="form-control form-control-md" name="data[comment]" id="invoice_comment" placeholder="comment"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#invoiceModal').modal('hide');$('#categoryModal').modal('show')">Close</button>
                    <button type="button" class="btn btn-primary" onclick="Dashboard.saveInvoice()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- invoice item Modal -->
    <div class="modal fade" id="invoiceItemModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="invoiceItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">invoiceItem</h5>
                    <a class="close" style="cursor: pointer" onclick="$('#invoiceItemModal').modal('hide');$('#invoiceModal').modal('show');" aria-label="Close">
                        <i class="mdi mdi-close" id="fullscreen-button"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" id="quality" placeholder="quality">
                            </div>
                            <div class="form-group">
                                <textarea rows="3" class="form-control form-control-md" id="descriptionItem" placeholder="description"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" id="price" placeholder="price">
                            </div>
                        <input type="hidden" id="hid_invoiceItem_mode" value="add">
                        <input type="hidden" id="hid_invoiceItem_index" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="Dashboard.saveInvoiceItem()">Save</button>
                </div>
            </div>
        </div>
    </div>

     <!-- invoice list Modal -->
    <div class="modal fade" id="invoiceListModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="invoiceListModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">invoiceItem</h5>
                    <a class="close" style="cursor: pointer" onclick="$('#invoiceListModal').modal('hide');" aria-label="Close">
                        <i class="mdi mdi-close" id="fullscreen-button"></i>
                    </a>
                </div>
                <div class="modal-body">
                     <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Invoice No</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice_list_body">

                                    </tbody>
                                </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        let BASE_URL = "{{url('')}}";
    </script>
    <script src="{{asset('assets/custom/dashboard.js')}}"></script>
@endsection
