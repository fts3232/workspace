import React from 'react';
import PropTypes from 'prop-types';

class CounterUI extends React.Component {
    render() {
        const { value, onIncreaseClick } = this.props
        return (
            <div>
                <span>{value}</span>
                <button onClick={onIncreaseClick}>Increase</button>
            </div>
        )
    }
}

CounterUI.propTypes={//属性校验器，表示改属性必须是bool，否则报错
    value: PropTypes.number.isRequired,
    onIncreaseClick: PropTypes.func.isRequired
}
CounterUI.defaultProps={
    
};//设置默认属性

export default CounterUI