const Dashboard = {
    actionLogout : () => {
        let url = '/auth/logout';
        $.ajax({
            type: "POST",
            url: url,
            success: (response)=> {
                if (response === 'success') {
                    location.href='/';
                }
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },
    getInvoiceList : (id) => {
        $.ajax({
            type: "GET",
            url: '/getInvoiceList/'+id,
            success: (response)=> {
                let html='';
                for(let temp of response){
                    html += '<tr><td> <button type="button" class="btn btn-sm btn-outline-info" title="Export Invoice to PDF" onclick="Dashboard.pdfExport('+temp.id+')"><i class="mdi mdi-file-download-outline menu-icon"></i></button></td>'
                    html += '<td>'+temp.invoice_no+'</td></tr>'
                }

                $('#invoice_list_body').html(html);
                $('#invoiceListModal').modal('show');
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },
    preview : () => {
        frame.src = URL.createObjectURL(event.target.files[0]);
    },
    editCustomer: (id) => {
        let url = '/getCustomerInfo/'+id;
        $('#hid_mode').val('edit');
        $.ajax({
            type: "GET",
            url: url,
            success: (response)=> {
                if (response.status === 'success') {
                    console.log(response);
                    $('#title').val(response.customer.title);
                    $('#mobile_phone').val(response.customer.mobile_phone);
                    $('#customer_email').val(response.customer.email);
                    $('#name').val(response.customer.name);
                    $('#address').val(response.customer.address);
                    $('#town').val(response.customer.town);
                    $('#postal_code').val(response.customer.postal_code);
                    $('#created_at').val(response.customer.created_at);
                    $('#updated_at').val(response.customer.updated_at);
                    $('#remind_date').val(response.customer.remind_date);
                    $('#further_note').val(response.customer.further_note);
                    $('#hid_attached_files').val(response.customer.attached_files);
                    $('#sms_sent').val(response.customer.sms_sent).change();
                    $('#state').val(response.customer.state).change();
                    $('#category').val(response.customer.category_id).change();
                    let files = response.customer.attached_files;
                    let parsed = JSON.parse(files);
                    for(let value of parsed) {
                        let mockFile = { name: value, size: 100};
                        dropzoneInstance.emit("addedfile", mockFile);
                        dropzoneInstance.emit("thumbnail", mockFile, 'uploads/'+value);
                        dropzoneInstance.emit("complete", mockFile);
                    };
                    $('#customer_id').val(response.customer.id);
                    if (response.invoices.length > 0){
                        let html = '';
                        for (let tmp of response.invoices){
                            html += '<tr id="invoice_row_'+tmp.id+'"><th scope="row"><i class="mdi mdi-close text-danger" style="cursor: pointer" onclick="Dashboard.deleteInvoice('+tmp.id+')"></i></th> <td><input type="hidden" name="data[invoiceIds]['+tmp.id+']" value="'+tmp.id+'">'+tmp.invoice_no+'</td></tr>';
                        }
                        $('#invoice_nodata').remove();
                        $('#invoice_body').append(html);
                    }
                    // $('#category').val(response.customer.category_id).change();
                    $('#categoryModal').modal('show');
                }
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },
    addInvoice : () => {
        $('#categoryModal').modal('hide');
        $('#invoiceModal').modal('show');
    },
    addInvoiceItem : () => {
        $('#invoiceModal').modal('hide');
        $('#quality').val('');
        $('#descriptionItem').val('');
        $('#price').val('');
        $('#invoiceItemModal').modal('show');
    },
    saveInvoiceItem : () => {
        let originalItems = $('#hid_invoice_items').val();
        let parsed = JSON.parse(originalItems);
        let temp = {};
        temp.quality = $('#quality').val();
        temp.price = $('#price').val();
        temp.description = $('#descriptionItem').val();
        parsed.push(temp);
        let encoded = JSON.stringify(parsed);
        $('#hid_invoice_items').val(encoded);
        let html = '';
        for (let item of parsed){
            html += '<tr>'+
                '<th scope="row"><i class="mdi mdi-close text-danger" style="cursor: pointer"></i></th>'+
                '<td>'+item.quality+'</td>'+
                '<td>'+item.description+'</td>'+
                '<td>'+item.price+'</td>'+
                '</tr>';
        }
        $('#invoice_item_body').html(html);
        $('#invoiceItemModal').modal('hide');
        $('#invoiceModal').modal('show');
    },
    saveInvoice : () => {
        let data = $('#invoice_form').serialize();
        console.log(data);
        let url = '/insertInvoice';
        $.ajax({
            type: "POST",
            url,
            data,
            success: (response)=> {
                let html = '<tr id="invoice_row_'+response.id+'"><th scope="row"><i class="mdi mdi-close text-danger" style="cursor: pointer" onclick="Dashboard.deleteInvoice('+response.id+')"></i></th> <td><input type="hidden" name="data[invoiceIds]['+response.id+']" value="'+response.id+'">'+response.result.invoice_no+'</td></tr>';
                $('#invoice_nodata').remove();
                $('#invoice_body').append(html);
                $('#invoiceModal').modal('hide');
                $('#categoryModal').modal('show');
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },

    saveCustomer : () => {
        let data = $('#customer_form').serialize();
        let mode = $('#hid_mode').val();
        let url;
        if (mode === 'add'){
            url = '/insertCustomer';
        }
        else {
            url = '/updateCustomer/'+$('#customer_id').val();
        }

        $.ajax({
            type: "POST",
            url,
            data,
            success: (response)=> {
                location.reload();
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },
    deleteCustomer : (id) => {
        x = confirm('Do you want to delete?');
        if(!x)  return false;
        let url = '/deleteCustomer/'+id;
        $.ajax({
            type: "GET",
            url,
            success: (response)=> {
                location.reload();
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },
    deleteInvoice : (id) => {
        x = confirm('Do you want to delete?');
        if(!x)  return false;
        let url = '/deleteInvoice/'+id;
        $.ajax({
            type: "GET",
            url,
            success: (response)=> {
                $('#invoice_row_'+id).remove();
                if($('#invoice_body').children().length < 1){
                    $('#invoice_body').html('<tr id="invoice_nodata"><td colspan="2" class="text-center" >No Data</td></tr>');
                }
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },

    pdfExport : (id) => {
        let url = '/pdfInvoiceExport/'+id;
        window.open(BASE_URL + url,'blank');
    }
}
let dropzoneInstance;
Dropzone.autoDiscover = false;
$(document).ready(function(){
    $('#import_file_btn').change(function (){
        $('#customer_csv_form').submit();
    });
    $('#import_invoice_btn').change(function (){
        $('#invoice_csv_form').submit();
    });
    $('#search_status').change(function (){
        $('#search_form').submit();
    });
    $('#search_category').change(function (){
        $('#search_form').submit();
    });
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        orientation: "bottom left" // left bottom of the input field
    });
    let originFile;
    $("#my-dropzone").dropzone({
        url: "/customer/attach_file", // If not using a form element
        init : function (){
            dropzoneInstance = this;
        },
        success: function(file, response){
            let fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = response;
            // file.previewElement.filename = response;
            // console.log(file.previewElement.filename);
            originFile = JSON.parse($('#hid_attached_files').val());
            originFile.push(response);
            $('#hid_attached_files').val(JSON.stringify(originFile));
        },
        addRemoveLinks: true, // Don't show remove links on dropzone itself.
        removedfile: function(file) {
            console.log(file.name);
            x = confirm('Do you want to delete?');
            if(!x)  return false;
            file.previewElement.remove();
            let originFiles = JSON.parse($('#hid_attached_files').val());
            let temp = [];
            for (let tmp of originFiles){
                if (tmp !== file.name){
                    temp.push(tmp);
                }
            }
            $('#hid_attached_files').val(JSON.stringify(temp));
        },
    });
})
