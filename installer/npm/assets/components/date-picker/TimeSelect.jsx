import React from 'react';
import ClickOutside from 'react-click-outside';
import Component from '../component';
import style from './style/main.scss';
import { parseDate } from './parseTime';

class TimeSelect extends Component {
    constructor(props) {
        super(props);
        this.state = {
            value  : props.value,
            visible: false
        };
    }

    getChildContext() {
        return {
            component: this
        };
    }

    handleItemClick(item) {
        if (!item.disabled) {
            this.setState({ value: item.value, visible: false });
        }
    }

    handleClickOutside() {
        if (this.state.visible) {
            this.setState({ visible: false });
        }
    }

    onFocus() {
        this.setState({ visible: true });
    }

    handleClear() {
        this.setState({ value: '' });
    }

    render() {
        const { placeholder, start, end, step, minTime, maxTime } = this.props;
        return (
            <div className="time-picker" onFocus={this.onFocus.bind(this)}>
                <Input readonly='true' value={this.state.value} placeholder={placeholder} icon='clock-o' onIconClick={this.handleClear.bind(this)}/>
                {this.state.visible && (<TimeSelectPanel start={start} end={end} step={step} value={this.state.value} minTime={minTime} maxTime={maxTime}/>)}
            </div>
        );
    }
}

TimeSelect.childContextTypes = {
    component: PropTypes.any
};

TimeSelect.PropTypes = {
    value      : PropTypes.string,
    placeholder: PropTypes.string,
    start      : PropTypes.string,
    end        : PropTypes.string,
    step       : PropTypes.string,
    minTime    : PropTypes.string,
    maxTime    : PropTypes.string
};

TimeSelect.defaultProps = {
    value      : '',
    placeholder: '请选择时间',
    start      : '00:00',
    end        : '23:30',
    step       : '00:30',
    maxTime    : '23:60',
    minTime    : '-1:-1'
};

export default ClickOutside(TimeSelect);