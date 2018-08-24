import React from 'react';
import PropTypes from 'prop-types';
import Component from '../../../component';

class DateTable extends Component {

    onClick(date) {
        this.parent().changeDate(date);
    }

    getRows() {
        const { date, value } = this.props;
        const today = date.getDate();
        const prevMonth = new Date();
        prevMonth.setMonth(date.getMonth());
        const nextMonth = new Date();
        nextMonth.setMonth(date.getMonth() + 1);
        const rows = [[], [], [], [], [], []];


        date.setDate(1);
        const firstDay = date.getDay();
        nextMonth.setDate(0);
        const lastDay = nextMonth.getDate();

        prevMonth.setDate(0);
        const prevMonthDays = prevMonth.getDate();
        const prevDayCount = firstDay === 0 ? 6 : firstDay - 1;

        let days = 1;
        let type = 'current';
        const year = date.getFullYear();
        let month = date.getMonth();
        date.setDate(today);
        for (let i = 0; i < 6; i++) {
            for (let j = 0; j < 7; j++) {
                if (i === 0 && prevMonthDays - prevDayCount + j <= prevMonthDays) {
                    rows[i].push({
                        type : 'prev',
                        value: new Date(year, month - 1, prevMonthDays - prevDayCount + j, 0, 0, 0),
                        month: parseInt(prevMonth.getMonth() + 1, 0),
                        day  : prevMonthDays - prevDayCount + j,
                        year : parseInt(date.getFullYear(), 0)
                    });
                }
                else {
                    rows[i].push({ type, value: new Date(year, month, days), month, day: parseInt(days, 10), year, isToday: value.toDateString() === new Date(year, month, days).toDateString() });
                    days++;
                    if (days > lastDay) {
                        days = 1;
                        type = 'next';
                        month += 1;
                    }
                }
            }
        }

        return rows;
    }

    parent() {
        const { component } = this.context;
        return component;
    }

    render() {
        const rows = this.getRows();
        return (
            <table cellSpacing="0" cellPadding="0" className="date-table">
                <tbody>
                    <tr>
                        <th>日</th>
                        <th>一</th>
                        <th>二</th>
                        <th>三</th>
                        <th>四</th>
                        <th>五</th>
                        <th>六</th>
                    </tr>
                    {rows.map((row, index) => (
                        <tr key={index}>
                            {row.map((v, key) => (
                                <td className={this.classNames(v.type, v.isToday && 'is-today')} key={key}>
                                    <div role="button" onClick={this.onClick.bind(this, v.value)}>{v.isToday ? '今天' : v.day}</div>
                                </td>
                            ))}
                        </tr>
                    ))}
                </tbody>
            </table>
        );
    }
}

DateTable.contextTypes = {
    component: PropTypes.any
};

DateTable.propTypes = {
    date : PropTypes.any.isRequired,
    value: PropTypes.any.isRequired
};

DateTable.defaultProps = {};

export default DateTable;