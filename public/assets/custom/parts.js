const Part = {
    saveItem : () => {
        let data = $('#category_form').serialize();
        let mode = $('#hid_mode').val();
        let url='';
        if (mode === 'add') {
            url = '/insertParts';
        }
        else {
            url = '/updateParts';
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
    editItem: (id) => {
        if (!id){
            return 'no_id'
        }
        let record = $('#record_'+id).val();
        let decoded = JSON.parse(record);
        $('#category_id').val(id);
        $('#q').val(decoded.q);
        $('#mq').val(decoded.mq);
        $('#description').val(decoded.description);
        $('#pnq').val(decoded.pnq);
        $('#hid_mode').val('edit');
        $('#categoryModal').modal('show');
    },
    deleteItem : (id) => {
        if (!confirm('Do you really delete this category?')){
            return;
        }
        if (!id) {
            return 'no_id';
        }
        let url = '/deleteParts/'+id;
        $.ajax({
            type: "GET",
            url,
            success: (response)=> {
                if (response === 'success') {
                    location.reload();
                }
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    }
}
$(document).ready(function(){
    $('#import_file_btn').change(function (){
        $('#parts_form').submit();
    });
})
