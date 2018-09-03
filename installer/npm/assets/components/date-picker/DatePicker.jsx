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
            visible: false,
            value  : props.value
        };
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
        const { setData } = this.context;
        const { name } = this.props;
        setData(name, formatDate(value));
        this.setState({ visible: false, value: formatDate(value) });
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
        const { placeholder, name, id } = this.props;
        const { value } = this.state;
        return (
            <div className={this.classNames('date-picker')} onFocus={this.onFocus}>
                <Input name={name} id={id} readonly value={value} placeholder={placeholder}/>
                {visible && (<Panel value={value}/>)}
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

DatePicker.childContextTypes = {
    component: PropTypes.any
};

DatePicker.contextTypes = {
    setData: PropTypes.func
};

// 导出组件
export default ClickOutside(DatePicker);