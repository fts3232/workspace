import React from 'react';
import ClickOutside from 'react-click-outside';
import PropTypes from 'prop-types';
import Component from '../component';
import { formatDate } from './parseTime';
import Panel from './panel/DatePickerPanel';
import { Input } from '../form';

class DatePicker extends Component {
    constructor(props) {
        super(props);
        this.onFocus = this.onFocus.bind(this);
        this.state = {
            visible: false
        };
    }

    onFocus() {
        this.setState({ visible: true });
    }

    handleItemClick() {
        this.setState({ visible: false });
    }

    handleClickOutside() {
        const { visible } = this.state;
        if (visible) {
            this.setState({ visible: false });
        }
    }

    handleClear() {
        this.setState({ visible: false });
    }

    render() {
        const { visible } = this.state;
        const { placeholder, name, value, id } = this.props;
        return (
            <div className={this.classNames('date-picker')} onFocus={this.onFocus}>
                <Input name={name} id={id} readonly value={formatDate(value)} placeholder={placeholder}/>
                {visible && (<Panel value={formatDate(value)}/>)}
            </div>
        );
    }
}

DatePicker.propTypes = {
    value      : PropTypes.any,
    placeholder: PropTypes.string,
    name       : PropTypes.string.isRequired,
    visible    : PropTypes.bool
};

DatePicker.defaultProps = {
    value      : '',
    placeholder: '请选择日期',
    visible    : false
};

// 导出组件
export default ClickOutside(DatePicker);