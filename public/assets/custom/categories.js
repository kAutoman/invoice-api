const Category = {
    insertCategory : () => {
        let data = $('#category_form').serialize();
        let mode = $('#hid_mode').val();
        let url;
        if (mode === 'add') {
            url = '/insertCategory';
        }
        else {
            url = '/updateCategory';
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
        console.log(record);
        let decoded = JSON.parse(record);
        $('#category_id').val(id);
        $('#category_name').val(decoded.name);
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
        let url = '/deleteCategory/'+id;
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

})
