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

function pad_zero(i) {
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

/**
 * 创建栏目项
 *
 * @param item
 * @param select
 * @param depth
 * @returns {jQuery|HTMLElement}
 */
function create_category_option(item, select, depth) {
    var before = '';
    for (i = 0; i < depth; i++) {
        before += '|－';
    }
    var li = $('<option value="' + item.CATEGORY_ID + '">' + before + item.CATEGORY_NAME + '</option>');
    if (select == item.CATEGORY_ID) {
        li.attr('selected', true);
    }
    return li
}

/**
 * 创建栏目
 *
 * @param category
 * @param select
 * @param depth
 */
function create_category_select(category, select, depth) {
    var depth = depth == undefined ? 0 : depth;
    category.map(function (v, k) {
        var item = create_category_option(v, select, depth);
        item.appendTo($('select.category'));
        if (v.CHILD != '') {
            create_category_select(v.CHILD, select, depth + 1);
        }
    })
}

$(document).ready(function () {
    //判断哪些菜单处于激活状态
    var scores = [];
    $('body>.nav').find('a').map(function (i) {
        var pathName = location.pathname.substring(1).split('/');
        var href = $('body>.nav').find('a').eq(i).attr('href').substring(1).split('/');
        var score = 0;
        href.map(function (v, k) {
            if (v == pathName[k]) {
                score += 25;
            }
        });
        scores.push({'index':i,'score':score});
    });

    var compare = function (obj1, obj2) {
        var val1 = obj1.score;
        var val2 = obj2.score;
        if (val1 > val2) {
            return -1;
        } else if (val1 < val2) {
            return 1;
        } else {
            return 0;
        }
    }
    scores.sort(compare);

    var li = $('body>.nav').find('a').eq(scores[0]['index']).parents('li');
    li.addClass('active');
    if (li.length > 1) {
        li.eq(li.length - 1).find('span.glyphicon').addClass('glyphicon-minus').removeClass('glyphicon-plus');
    }

    //警告框-关闭按钮
    $('.alert .close').on('click', function () {
        // do something…
        $('.alert').removeClass('in').addClass('out');
    });

    //头部展开菜单栏按钮
    $('.header .menu a.btn').on('click', function () {
        var menu = $('body>.nav');
        if (menu.hasClass('out')) {
            $('body>.container-fluid').removeClass('full');
            menu.addClass('in').removeClass('out');
        } else {
            $('body>.container-fluid').addClass('full');
            menu.addClass('out').removeClass('in');
        }
    });

    //菜单栏
    $('body>.nav li').on('click', function () {
        var subNav = $(this).find('.sub-nav');
        if (subNav.length > 0) {
            if ($(this).hasClass('active')) {
                subNav.hide();
                $(this).removeClass('active');
                $(this).find('span.glyphicon').addClass('glyphicon-plus').removeClass('glyphicon-minus');
            } else {
                subNav.show();
                $(this).addClass('active');
                $(this).find('span.glyphicon').addClass('glyphicon-minus').removeClass('glyphicon-plus');
            }
        }
    });
});