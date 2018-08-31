import React from 'react';
import ClickOutside from 'react-click-outside';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
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

    getChildContext() {
        return {
            component: this
        };
    }

    onFocus() {
        this.setState({ visible: true });
    }

    handleItemClick(value) {
        const { setData } = this.props;
        setData(formatDate(value));
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

const mapState = (state, ownProps) => ({
    value: typeof state.data[ownProps.name] !== 'undefined' ? state.data[ownProps.name] : ownProps.value,
    error: typeof state.error[ownProps.name] !== 'undefined' ? state.error[ownProps.name] : ''
});
const mapDispatch = (dispatch, ownProps) => ({
    setData: (value) => {
        dispatch({ 'type': 'SET_DATA', value, name: ownProps.name });
    }
});


// 导出组件
export default connect(mapState, mapDispatch)(ClickOutside(DatePicker));