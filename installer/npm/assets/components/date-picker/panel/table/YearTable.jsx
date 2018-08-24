import React from 'react';
import PropTypes from 'prop-types';
import Component from '../../../component';

class YearTable extends Component {

    onClick(value) {
        this.parent().changeYear(value);
    }

    getRows() {
        const { date, value } = this.props;
        const startYear = Math.floor(date.getFullYear() / 10) * 10;
        const rows = [[], [], [], [], [], []];
        let j = 0;
        const valueYear = value.getFullYear();
        const valueMonth = value.getMonth();
        const valueDate = value.getDate();
        for (let i = 0; i < 9; i++) {
            const year = startYear + i + 1;
            rows[j].push({ type: year < valueYear ? 'prev' : null, 'label': year, value: year, isCurrent: value.toDateString() === new Date(year, valueMonth, valueDate).toDateString() });
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
            <table cellSpacing="0" cellPadding="0" className="year-table">
                {rows.map((row, index) => (
                    <tr key={index}>
                        {row.map((v, key) => (
                            <td className={this.classNames(v.type, v.isCurrent && 'is-current')} key={key} >
                                <div role="button" onClick={this.onClick.bind(this, v.value)}>{v.label}</div>
                            </td>
                        ))}
                    </tr>
                ))}

            </table>
        );
    }
}

YearTable.contextTypes = {
    component: PropTypes.any
};

YearTable.propTypes = {
    date : PropTypes.any.isRequired,
    value: PropTypes.any.isRequired
};

YearTable.defaultProps = {};

export default YearTable;