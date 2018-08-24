import React from 'react';
import PropTypes from 'prop-types';
import Component from '../../component';
import Icon from '../../icon';
import { DateTable, MonthTable, YearTable } from './table';
import { parseDate } from '../parseTime';

class DatePickerPanel extends Component {
    constructor(props) {
        super(props);
        this.state = {
            value      : parseDate(props.value) || new Date(),
            date       : parseDate(props.value) || new Date(),
            currentView: 'date'
        };
    }

    getChildContext() {
        return {
            component: this
        };
    }

    getYearLabel() {
        const { date, currentView } = this.state;
        const year = date.getFullYear();
        let startYear;
        let endYear;
        switch (currentView) {
            case 'year':
                startYear = Math.floor(year / 10) * 10;
                endYear = startYear + 9;
                return `${ startYear }年-${ endYear }年`;
            default:
                return `${ year }年`;
        }
    }

    parent() {
        const { component } = this.context;
        return component;
    }

    changeView(view) {
        this.setState({ currentView: view });
    }

    changeYear(year) {
        const { date } = this.state;
        date.setFullYear(year);
        this.setState({ currentView: 'month', date });
    }

    changeMonth(month) {
        const { date } = this.state;
        date.setMonth(month);
        this.setState({ currentView: 'date', date });
    }

    changeDate(date) {
        this.parent().handleItemClick(date);
    }

    nextYear() {
        const { date, currentView } = this.state;
        let startYear;
        switch (currentView) {
            case 'year':
                startYear = Math.floor(date.getFullYear() / 10) * 10;
                date.setFullYear(startYear + 10);
                this.setState({ date });
                break;
            default:
                date.setFullYear(date.getFullYear() + 1);
                this.setState({ date });

        }
    }

    prevYear() {
        const { date, currentView } = this.state;
        let startYear;
        switch (currentView) {
            case 'year':
                startYear = Math.floor(date.getFullYear() / 10) * 10;
                date.setFullYear(startYear - 10);
                this.setState({ date });
                break;
            default:
                date.setFullYear(date.getFullYear() - 1);
                this.setState({ date });
        }
    }

    prevMonth() {
        const { date } = this.state;
        date.setMonth(date.getMonth() - 1);
        this.setState({ date });
    }

    nextMonth() {
        const { date } = this.state;
        if (date.getMonth() === 11) {
            date.setMonth(0);
            date.setFullYear(date.getFullYear() + 1);
        } else {
            date.setMonth(date.getMonth() + 1);
        }
        this.setState({ date });
    }

    render() {
        const { date, currentView, value } = this.state;
        const month = parseInt(date.getMonth() + 1, 10);
        return (
            <div className="picker-panel date-picker" ref={(root)=>{ this.root = root; }}>
                <div className="date-picker-header">
                    <Icon name="angle-double-left" className="prev-btn" onClick={this.prevYear.bind(this)}/>
                    {currentView === 'date' && (
                        <Icon name="angle-left" className="prev-btn" onClick={this.prevMonth.bind(this)}/>
                    )}
                    <span className="date-picker-header-label" role="button" onClick={this.changeView.bind(this, 'year')}>{this.getYearLabel()}</span>
                    {currentView === 'date' && (
                        <span className="date-picker-header-label" role="button" onClick={this.changeView.bind(this, 'month')}>{month}月</span>
                    )}
                    <Icon name="angle-double-right" className="next-btn" onClick={this.nextYear.bind(this)}/>
                    {currentView === 'date' && (
                        <Icon name="angle-right" className="next-btn" onClick={this.nextMonth.bind(this)}/>
                    )}
                </div>
                <div className="date-picker-body">
                    {currentView === 'date' && (
                        <DateTable value={value} date={date}/>
                    )}
                    {currentView === 'month' && (
                        <MonthTable value={value} date={date}/>
                    )}
                    {currentView === 'year' && (
                        <YearTable value={value} date={date}/>
                    )}
                </div>
            </div>
        );
    }
}

DatePickerPanel.childContextTypes = {
    component: PropTypes.any
};

DatePickerPanel.contextTypes = {
    component: PropTypes.any
};

DatePickerPanel.propTypes = {
    value: PropTypes.any
};

DatePickerPanel.defaultProps = {
    value: new Date()
};

export default DatePickerPanel;