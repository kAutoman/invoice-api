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
    editCustomer: (id) => {
        let url = '/getCustomerInfo/'+id;
        $.ajax({
            type: "GET",
            url: url,
            success: (response)=> {
                if (response.status === 'success') {
                    
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
        let url = '/insertCustomer';
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
            console.log(file.upload);
            x = confirm('Do you want to delete?');
            if(!x)  return false;
            file.previewElement.remove();
        },
    });
})
