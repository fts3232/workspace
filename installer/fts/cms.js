//警告框
var alertMessageTimer = null;

function alertMessage(type, message, error) {
    clearTimeout(alertMessageTimer);
    $('.alert').removeClass('alert-success alert-danger alert-info alert-warning');
    var className;
    switch (type) {
        case 'success':
            className = 'alert-success'
            break;
        case 'danger':
            className = 'alert-danger'
            break;
        case 'warning':
            className = 'alert-warning'
            break;
        case 'info':
            className = 'alert-info'
            break;
    }
    $('.alert').addClass('in').addClass(className).removeClass('out');
    if (error != undefined) {
        message += ' 错误码: ' + error
    }
    $('.alert p').html(message);
    alertMessageTimer = setTimeout(function () {
        $('.alert').removeClass('in').addClass('out');
    }, 3000)
}

$(document).ready(function () {
    //警告框-关闭按钮
    $('.alert .close').on('click', function () {
        // do something…
        $('.alert').removeClass('in').addClass('out');
    })
})
