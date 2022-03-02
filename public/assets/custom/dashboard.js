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
    addCustomer : () => {
        $('#hid_mode').val('add');
        $('#categoryModal').modal('show');
        $('#customer_form')[0].reset();
        $('#invoice_body').html('<tr id="invoice_nodata">\n' +
            '   <td colspan="2" class="text-center" >No Data</td>\n' +
            '</tr>');
        $('.dz-image-preview').remove();
    },
    preview1 : () => {
        frame1.src = URL.createObjectURL(event.target.files[0]);
    },
    preview2 : () => {
        frame2.src = URL.createObjectURL(event.target.files[0]);
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
                    $('.dz-image-preview').remove();
                    Dropzone.forElement("#my-dropzone").removeAllFiles(true);
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
                            html += '<tr id="invoice_row_'+tmp.id+'"><th scope="row"><i class="mdi mdi-close text-danger" style="cursor: pointer" onclick="Dashboard.deleteInvoice('+tmp.id+')"></i></th> <td class="cursor-pointer" onclick="Dashboard.editInvoice('+tmp.id+')"><input type="hidden" id="invoiceData_'+tmp.id+'" value='+"'"+JSON.stringify(tmp).replace(/'/g,"\'")+ "'" +'><input type="hidden" name="data[invoiceIds]['+tmp.id+']" value="'+tmp.id+'">'+tmp.invoice_no+'</td></tr>';
                        }
                        $('#invoice_nodata').remove();
                        $('#invoice_body').html('');
                        $('#invoice_body').append(html);
                    }else {
                        $('#invoice_body').html('<tr id="invoice_nodata">\n' +
                            '   <td colspan="2" class="text-center" >No Data</td>\n' +
                            '</tr>');
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
    editInvoice : (invoiceItemId) => {
        $('#categoryModal').modal('hide');
        let invoiceItem = $('#invoiceData_'+invoiceItemId).val();
        console.log(invoiceItem);
        invoiceItem = JSON.parse(invoiceItem);
        $('#invoice_form')[0].reset();
        if (invoiceItem.preset1){
            $('#frame1').attr('src','/uploads/invoice/'+invoiceItem.preset1);
        }
        if (invoiceItem.preset2){
            $('#frame2').attr('src','/uploads/invoice/'+invoiceItem.preset2);
        }
        $('#invoice_no').val(invoiceItem.invoice_no);
        $('#invoice_email').val(invoiceItem.email);
        $('#invoice_date').val(invoiceItem.invoice_date);
        $('#invoice_mobile_num').val(invoiceItem.mobile_num);
        $('#invoice_to').val(invoiceItem.to);
        $('#invoice_from_addr').val(invoiceItem.from_address);
        $('#hid_invoice_items').val(invoiceItem.items);
        $('#hid_invoice_mode').val('edit');
        $('#hid_invoice_id').val(invoiceItemId);
        $('#invoice_item_body').html('');
        let html = '';
        let parsed = JSON.parse(invoiceItem.items);
        let i= 0;
        for (let item of parsed){
            html += '<tr>'+
                '<th scope="row"><i class="mdi mdi-close text-danger" style="cursor: pointer" onclick="$(this).parent().parent().remove();Dashboard.removeInvoiceItem('+i+');"></i></th>'+
                '<td  class="cursor-pointer" onclick="Dashboard.editInvoiceItem('+i+');">'+item.quality+'</td>'+
                '<td  class="cursor-pointer" onclick="Dashboard.editInvoiceItem('+i+');">'+item.description+'</td>'+
                '<td  class="cursor-pointer" onclick="Dashboard.editInvoiceItem('+i+');">'+item.price+'</td>'+
                '</tr>';
            i++;
        }
        if (html === ''){
            html = ' <tr>\n' +
                '      <td colspan="4" class="text-center">No data</td>\n' +
                '    </tr>';
        }
        $('#invoice_item_body').html(html);
        $('#invoiceModal').modal('show');
    },
    removeInvoiceItem : (index) => {
        let items = $('#hid_invoice_items').val();
        let parsed = JSON.parse(items);
        parsed.splice(index,1);
        let encoded = JSON.stringify(parsed);
        if (parsed.length === 0){
            $('#invoice_item_body').html('  <tr>\n' +
                '    <td colspan="4" class="text-center">No data</td>\n' +
                '</tr>');
        }
        $('#hid_invoice_items').val(encoded);
    },
    editInvoiceItem : (index) => {
        let items = $('#hid_invoice_items').val();
        let parsed = JSON.parse(items);
        let record = parsed[index];
        $('#invoiceModal').modal('hide');
        $('#quality').val(record.quality);
        $('#descriptionItem').val(record.description);
        $('#price').val(record.price);
        $('#hid_invoiceItem_mode').val('edit');
        $('#hid_invoiceItem_index').val(index);
        $('#invoiceItemModal').modal('show');
    },
    addInvoice : () => {
        $('#hid_invoice_mode').val('add');
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
        let mode = $('#hid_invoiceItem_mode').val();
        if (mode === 'add'){
            parsed.push(temp);
        }
        else {
            let index = $('#hid_invoiceItem_index').val();
            parsed[index] = temp;
        }

        let encoded = JSON.stringify(parsed);
        $('#hid_invoice_items').val(encoded);
        let html = '';
        let i = 0;
        for (let item of parsed){
            html += '<tr class="cursor-pointer">'+
                '<th scope="row"><i class="mdi mdi-close text-danger" style="cursor: pointer"  onclick="$(this).parent().parent().remove();Dashboard.removeInvoiceItem('+i+');"></i></th>'+
                '<td onclick="Dashboard.editInvoiceItem('+i+');">'+item.quality+'</td>'+
                '<td onclick="Dashboard.editInvoiceItem('+i+');">'+item.description+'</td>'+
                '<td onclick="Dashboard.editInvoiceItem('+i+');">'+item.price+'</td>'+
                '</tr>';
            i++;
        }
        $('#invoice_item_body').html(html);
        $('#invoiceItemModal').modal('hide');
        $('#invoiceModal').modal('show');
    },
    saveInvoice : () => {
        $('#hid_customer_id').val($('#customer_id').val());
        let formData = new FormData($('#invoice_form')[0]);
        let url = '/insertInvoice';
        $.ajax({
            type: "POST",
            url,
            data:formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: (response)=> {
                let html = '<tr id="invoice_row_'+response.id+'"><th scope="row"><i class="mdi mdi-close text-danger" style="cursor: pointer" onclick="Dashboard.deleteInvoice('+response.id+')"></i></th> <td class="cursor-pointer" onclick="Dashboard.editInvoice('+response.id+')"><input type="hidden" id="invoiceData_'+response.id+'" value='+JSON.stringify(response)+'><input type="hidden" name="data[invoiceIds]['+response.id+']" value="'+response.id+'">'+response.result.invoice_no+'</td></tr>';
                $('#invoice_nodata').remove();
                let mode = $('#hid_invoice_mode').val();
                if (mode === 'edit'){
                    $('#invoice_row_'+response.id).remove();
                }
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
        if ($('#title').val() === '') {
            toastr.error('Please input title','Error!');
            return;
        }
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
    $('.date-picker').datetimepicker();
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
