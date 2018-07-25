import React from 'react';
import PropTypes from 'prop-types';

class Counter extends React.Component {
    constructor(props){
        super(props);
    }
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

Counter.propTypes={//属性校验器，表示改属性必须是bool，否则报错
    value: PropTypes.number.isRequired,
    onIncreaseClick: PropTypes.func.isRequired
}
Counter.defaultProps={
    
};//设置默认属性

export default Counter