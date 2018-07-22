//警告框
var alertMessageTimer = null;

function alertMessage(type, message, error) {
    clearTimeout(alertMessageTimer);
    $('.alert').removeClass('alert-success alert-danger alert-info alert-warning');
    var className;
    switch (type) {
        case 'success':
            className = 'alert-success';
            break;
        case 'danger':
            className = 'alert-danger';
            break;
        case 'warning':
            className = 'alert-warning';
            break;
        case 'info':
            className = 'alert-info';
            break;
    }
    $('.alert').addClass('in').addClass(className).removeClass('out');
    if (error != undefined) {
        message += ' 错误码: ' + error;
    }
    $('.alert p').html(message);
    alertMessageTimer = setTimeout(function () {
        $('.alert').removeClass('in').addClass('out');
    }, 3000);
}

function pad_zero(i){
    return i >= 10 ? i : '0' + i;
}

function calculate_depth(item, direction) {
    var parentLeft = parseInt(item.prev('.ui-sortable-handle').css('marginLeft'));
    if (isNaN(parentLeft)) {
        parentLeft = parseInt(item.parents('li').css('marginLeft'));
    }
    var ownLeft = parseInt(item.css('marginLeft'));
    var maxLeft = parentLeft + 30;
    if (direction == 'right') {
        var offset = ownLeft + 30 > maxLeft ? maxLeft : ownLeft + 30;
    } else {
        var offset = ownLeft - 30 < 0 ? 0 : ownLeft - 30;
    }
    var depth = offset / 30;
    item.attr('data-depth', depth);
    item.css('margin-left', offset + 'px');
    if (offset != ownLeft) {
        var child = item.find('ul').eq(0).find('li');
        child.map(function (i) {
            calculate_depth(child.eq(i), direction);
        });
    }
}

function reset_order() {
    var root = $('.sortable');
    var list = root.find('li');
    //排序
    var checkParent = [];
    list.map(function (i, v) {
        var parent = list.eq(i).attr('data-parent');
        if (checkParent.indexOf(parent) == -1) {
            var siblings = root.find('[data-parent="' + parent + '"]');
            siblings.map(function (i, v) {
                siblings.eq(i).attr('data-order', i);
            });
            checkParent.push[parent];
        }
    });
}

function clone_item(item, child) {
    var height = item.height();
    child.map(function (i) {
        item.find('ul').eq(0).append(child.eq(i).clone());
        var childID = child.eq(i).attr('data-id');
        height += child.eq(i).height();
        child.eq(i).remove();

        var temp = item.parent('ul').find('[data-parent="' + childID + '"]');
        clone_item(item, temp);
    });

    $('.ui-state-highlight').css('height', height + 'px');
}

$(document).ready(function () {
    //警告框-关闭按钮
    $('.alert .close').on('click', function () {
        // do something…
        $('.alert').removeClass('in').addClass('out');
    })
})