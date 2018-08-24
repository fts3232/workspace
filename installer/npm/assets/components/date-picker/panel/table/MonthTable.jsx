import React from 'react';
import PropTypes from 'prop-types';
import Component from '../../../component';

class MonthTable extends Component {
    onClick(date) {
        this.parent().changeMonth(date);
    }

    getRows() {
        const { date, value } = this.props;
        const rows = [[], [], []];
        const months = ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
        let j = 0;
        const year = date.getFullYear();
        const day = date.getDate();
        for (let i = 0; i < 12; i++) {
            const nDate = new Date(year, i, day);
            rows[j].push({ type: nDate < value ? 'prev' : null, 'label': months[i], value: i, isCurrent: value.toDateString() === nDate.toDateString() });
            if ((i + 1) % 4 === 0) {
                j++;
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
            <table cellSpacing="0" cellPadding="0" className="month-table">
                {rows.map((row, index) => (
                    <tr key={index}>
                        {row.map((v, key) => (
                            <td className={this.classNames(v.isCurrent ? 'is-current' : v.type)} key={key} >
                                <div role="button" onClick={this.onClick.bind(this, v.value)}>{v.label}</div>
                            </td>
                        ))}
                    </tr>
                ))}

            </table>
        );
    }
}

MonthTable.contextTypes = {
    component: PropTypes.any
};

MonthTable.propTypes = {
    date : PropTypes.any.isRequired,
    value: PropTypes.any.isRequired
};

MonthTable.defaultProps = {};

export default MonthTable;