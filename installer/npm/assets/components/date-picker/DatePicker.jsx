import React from 'react';
import ClickOutside from 'react-click-outside';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Component from '../component';
import style from './style/main.scss';
import { formatDate } from './parseTime';
import Panel from './panel/DatePickerPanel';
import { Input } from '../form';

class DatePicker extends Component {
    constructor(props) {
        super(props);
        this.onFocus = this.onFocus.bind(this);
        const { visible, setVisible, name } = props;
        setVisible(name, visible);
    }

    onFocus() {
        const { name, setVisible } = this.props;
        setVisible(name, true);
        // this.setState({ visible: true });
    }

    handleItemClick() {
        // this.setState({ visible: false });
    }

    handleClickOutside() {
        const { setVisible } = this.props;
        setVisible(false);
        /* const { visible } = this.state;
        if (visible) {
            this.setState({ visible: false });
        } */
    }

    handleClear() {
        // this.setState({ visible: false });
    }

    render() {
        const { placeholder, name, visible, value } = this.props;
        return (
            <div className={style['date-picker']} onFocus={this.onFocus}>
                <Input label="日期" name={name} readonly value={formatDate(value)} placeholder={placeholder}/>
                {visible && (<Panel value={formatDate(value)}/>)}
            </div>
        );
    }
}

DatePicker.propTypes = {
    value      : PropTypes.any,
    placeholder: PropTypes.string,
    name       : PropTypes.string.isRequired,
    visible    : PropTypes.bool,
    setVisible : PropTypes.func
};

DatePicker.defaultProps = {
    value      : '',
    placeholder: '请选择日期',
    visible    : false,
    setVisible : ()=>{}
};

// 导出组件
const mapStateToProps = (state, ownProps) => {
    const { name } = ownProps;
    let { visible } = ownProps;
    if (typeof state.dataPicker[name] !== 'undefined') {
        visible = state.dataPicker[name].visible;
    }
    return { visible };
};

const mapDispatchToProps = (dispatch) => ({
    setVisible: (name, visible) => {
        dispatch({ type: 'SET_VISIBLE', visible, name });
    }
});

export default connect(mapStateToProps, mapDispatchToProps)(ClickOutside(DatePicker));