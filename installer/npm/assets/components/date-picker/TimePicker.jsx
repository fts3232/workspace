import React from 'react';
import ClickOutside from 'react-click-outside';
import Component from '../component';
import style from './style/main.scss';
import { parseDate } from './parseTime';

class TimePicker extends Component {
    constructor(props) {
        super(props);
        this.state = {
            value  : props.value || format('hh:mm:ss', new Date()),
            time   : parseTime(props.value || new Date()),
            visible: false
        };
    }

    getChildContext() {
        return {
            component: this
        };
    }

    changeHour(v) {
        const { time } = this.state;
        time.hours = v.value;
        this.setState({ time, value: `${ time.hours }:${ time.minutes }:${ time.seconds }` });
    }

    changeMinute(v) {
        const { time } = this.state;
        time.minutes = v.value;
        this.setState({ time, value: `${ time.hours }:${ time.minutes }:${ time.seconds }` });
    }

    changeSecond(v) {
        const { time } = this.state;
        time.seconds = v.value;
        this.setState({ time, value: `${ time.hours }:${ time.minutes }:${ time.seconds }` });
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

    hide() {
        this.setState({ visible: false });
    }

    render() {
        const { placeholder, selectableRange } = this.props;
        const { visible } = this.state;
        return (
            <div className="time-picker" onFocus={this.onFocus.bind(this)}>
                <Input readonly='true' value={this.state.value} placeholder={placeholder} icon='clock-o' onIconClick={this.handleClear.bind(this)}/>

                {visible && (<TimePickerPanel selectableRange={selectableRange}/>)}
            </div>
        );
    }
}

TimePicker.childContextTypes = {
    component: PropTypes.any
};

TimePicker.PropTypes = {
    value          : PropTypes.string,
    placeholder    : PropTypes.string,
    selectableRange: PropTypes.oneOfType([PropTypes.string, PropTypes.array])
};

TimePicker.defaultProps = {
    value      : '',
    placeholder: '请选择时间'
};

export default ClickOutside(TimePicker);