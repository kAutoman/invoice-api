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
                    <button type="button" class="btn btn-sm btn-outline-behance" onclick="$('#hid_mode').val('add');$('#categoryModal').modal('show')"><i class="mdi mdi-plus menu-icon"></i>Add</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Customer Manage</h5>
                    <a class="close" style="cursor: pointer" onclick="$('#categoryModal').modal('hide')" aria-label="Close">
                        <i class="mdi mdi-close" id="fullscreen-button"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form id="customer_form">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[title]" id="title" placeholder="Title for tasks list...">
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
                            <div class="form-group"><input type="text" class="form-control form-control-md" name="data[created_at]"  placeholder="Date form created"></div>
                            <div class="form-group"><input type="text" class="form-control form-control-md" name="data[updated_at]"  placeholder="Date form updated"></div>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-md" name="data[remind_date]" id="remind_date" placeholder="remind date">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[further_note]" id="further_note" placeholder="Further note">
                            </div>
                            <div class="form-group">
                                <select name="data[state]" id="state" class="form-control-sm w-100">
                                    <option value="">select state</option>
                                    <option value="1">active</option>
                                    <option value="2">completed</option>
                                    <option value="3">waiting</option>
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

                            <input type="hidden" name="attached_files" id="hid_attached_files" value="[]">
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
                                        <tr>
                                            <td colspan="2" class="text-center">No Data</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#categoryModal').modal('hide')">Close</button>
                    <button type="button" class="btn btn-primary" onclick="Dashboard.saveItem()">Save Customer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- invoice Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
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
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[invoice_no]" id="q" placeholder="invoice No">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[email]" id="mq" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-md" name="data[invoice_date]" id="description" placeholder="invoice Date">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[mobile_num]"  placeholder="Mobile Number">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[to]"  placeholder="to">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[from_address]"  placeholder="from address">
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="hid_invoice_items" name="data[items]" value="[]">
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
                            <div class="form-group"><input type="text" class="form-control form-control-md" name="data[excluding_vat]"  placeholder="excluding vat"></div>
                            <div class="form-group"><input type="text" class="form-control form-control-md" name="data[vat_amount]"  placeholder="vat amount"></div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[invoice_total]"  placeholder="invoice total">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[payed_amount]"  placeholder="payed amount">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-md" name="data[due_total]"  placeholder="due total">
                            </div>
                            <div class="form-group">
                                <textarea rows="5" class="form-control form-control-md" name="data[comment]"  placeholder="comment"></textarea>
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
    <div class="modal fade" id="invoiceItemModal" tabindex="-1" role="dialog" aria-labelledby="invoiceItemModalLabel" aria-hidden="true">
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="Dashboard.saveInvoiceItem()">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/custom/dashboard.js')}}"></script>
@endsection
