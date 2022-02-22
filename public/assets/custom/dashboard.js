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
}
$(document).ready(function(){

})
