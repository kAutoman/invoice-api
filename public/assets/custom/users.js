const Users = {
    insertUser : () => {
        let data = $('#user_form').serialize();
        let mode = $('#hid_mode').val();
        let url;
        if (mode === 'add') {
            url = '/insertUser';
        }
        else {
            url = '/updateUser';
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
        $('#user_id').val(id);
        $('#user_name').val(decoded.email);
        $('#user_password').val(decoded.password);
        $('#hid_mode').val('edit');
        $('#userModal').modal('show');
    },
    deleteItem : (id) => {
        if (!confirm('Do you really delete this user?')){
            return;
        }
        if (!id) {
            return 'no_id';
        }
        let url = '/deleteUser/'+id;
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
