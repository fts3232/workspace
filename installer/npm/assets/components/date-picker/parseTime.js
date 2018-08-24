export function parseTime(time) {
    if (time instanceof Date) {
        return {
            hours  : time.getHours(),
            minutes: parseInt(time.getMinutes(), 10),
            seconds: parseInt(time.getSeconds(), 10)
        };
    }
    const values = time.split(':');
    if (values.length >= 2) {
        const hours = parseInt(values[0], 10);
        const minutes = parseInt(values[1], 10);
        const seconds = parseInt(values[2], 10);
        return {
            hours,
            minutes,
            seconds
        };
    }
    /* istanbul ignore next */
    return null;

}

export function parseDate(date) {
    if (date == null) {
        return null;
    }
    if (date instanceof Date) {
        date.setHours(0);
        date.setMinutes(0);
        date.setSeconds(0);
        return date;
    }
    const values = date.split('-');
    if (values.length >= 2) {
        const year = parseInt(values[0], 10);
        const month = parseInt(values[1], 10);
        const day = parseInt(values[2], 10);
        const newDate = new Date();
        newDate.setFullYear(year);
        newDate.setMonth(month - 1);
        newDate.setDate(day);
        newDate.setHours(0);
        newDate.setMinutes(0);
        newDate.setSeconds(0);
        return newDate;
    }
    /* istanbul ignore next */
    return null;

}

export function formatDate(date) {
    if (date instanceof Date) {
        let month = date.getMonth() + 1;
        month = month < 10 ? `0${ month }` : month;
        const year = date.getFullYear();
        let day = date.getDate();
        day = day < 10 ? `0${ day }` : day;
        return `${ year }-${ month }-${ day }`;
    }
    return '';

}

export function format(dateFormat, time) {
    const o = {
        'M+': time.getMonth() + 1, // 月份
        'd+': time.getDate(), // 日
        'h+': time.getHours(), // 小时
        'm+': time.getMinutes(), // 分
        's+': time.getSeconds(), // 秒
        'q+': Math.floor((time.getMonth() + 3) / 3), // 季度
        'S' : time.getMilliseconds() // 毫秒
    };
    let date = dateFormat;
    if (/(y+)/.test(date)) {
        date = date.replace(RegExp.$1, time.getFullYear().substr(4 - RegExp.$1.length));
    }
    Object.entries(o).map((v) => {
        if (new RegExp(v[0]).test(date)) {
            date = date.replace(RegExp.$1, RegExp.$1.length === 1 ? v[1] : `00${ v[1] }`.substr(v[1].length));
        }
        return v;
    });
    return date;
}