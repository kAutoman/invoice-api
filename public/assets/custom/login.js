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
    },
    recoverPassword : () => {
        let email = $('#exampleInputEmail1').val();
        if(!email){
            toastr.error('Please input email','Error!', {timeOut: 5000});
            return;
        }
        let url = '/recoverPassword/'+email;
        $.ajax({
            type: "get",
            url: url,
            dataType: 'json',
            success: (response)=> {
                if (response.status === 'success') {
                    toastr.success('Please check your phone SMS.','Success!', {timeOut: 5000});
                    location.href='/';
                }
            },
            error : (error) => {
                toastr.error(error.responseJSON,'Error!', {timeOut: 5000});
            }
        });
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
