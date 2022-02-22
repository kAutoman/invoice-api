const Login = {
    actionLogin : () => {
        let formData = $("#login_form").serialize();
        let url = '/auth/login';
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: 'json',
            success: (response)=> {
                if (response.status === 'success') {
                    toastr.success('','Success!', {timeOut: 5000});
                    location.href='/';
                }
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
    },
    clickedLogo:0,
    increaseLogo: () => {
        if (Login.clickedLogo >= 4) {
            location.href='/register';
            return;
        }
        Login.clickedLogo++;
    }
}
$(document).ready(function(){
    Login.clickedLogo = 0;
    $(document).on('keyup',function (e){
        if (e.keyCode === 13){
            Login.actionLogin();
        }
    })
})
