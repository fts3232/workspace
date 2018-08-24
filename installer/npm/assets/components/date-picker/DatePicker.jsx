import React from 'react';
import ClickOutside from 'react-click-outside';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';
import { parseDate, formatDate } from './parseTime';
import Panel from './panel/DatePickerPanel';
import { Input } from '../form';

class DatePicker extends Component {
    constructor(props) {
        super(props);
        this.state = {
            value  : parseDate(props.value),
            visible: false
        };
        this.onFocus = this.onFocus.bind(this);
    }

    getChildContext() {
        return {
            component: this
        };
    }

    onFocus() {
        this.setState({ visible: true });
    }

    handleItemClick(value) {
        this.setState({ value, visible: false });
    }

    handleClickOutside() {
        const { visible } = this.state;
        if (visible) {
            this.setState({ visible: false });
        }
    }

    handleClear() {
        this.setState({ value: '', visible: false });
    }

    render() {
        const { placeholder } = this.props;
        const { value, visible } = this.state;
        return (
            <div className={style['date-picker']} onFocus={this.onFocus}>
                <Input label="日期" readonly value={formatDate(value)} placeholder={placeholder} icon='calendar' onIconClick={this.handleClear}/>
                {visible && (<Panel value={formatDate(value)}/>)}
            </div>
        );
    }
}

DatePicker.childContextTypes = {
    component: PropTypes.any
};

DatePicker.propTypes = {
    value      : PropTypes.string,
    placeholder: PropTypes.string
};

DatePicker.defaultProps = {
    value      : '',
    placeholder: '请选择日期'
};

export default ClickOutside(DatePicker);