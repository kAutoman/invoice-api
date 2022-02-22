const Register = {
    actionRegister : () => {
        let formData = $("#register_form").serialize();
        let url = '/auth/register';
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: 'json',
            success: (response)=> {
                if (response === 'success') {
                    toastr.success('','Success!', {timeOut: 5000});
                    location.href='/';
                }
            },
            error : (error) => {
                console.log(error.responseJSON);
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },
}
$(document).ready(function(){

})
