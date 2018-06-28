import React from 'react';
import PropTypes from 'prop-types';
import { createStore } from 'redux'
import { Provider, connect } from 'react-redux'


class Counter extends React.Component {
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

// Action
const increaseAction = { type: 'increase' }

// Reducer
function counter(state = { count: 100 }, action) {
    const count = state.count
    switch (action.type) {
        case 'increase':
            return { count: count + 1 }
        default:
            return state
    }
}

// Store
const store = createStore(counter)

// Map Redux state to component props
function mapStateToProps(state) {
    return {
        value: state.count
    }
}

// Map Redux actions to component props
function mapDispatchToProps(dispatch) {
    return {
        onIncreaseClick: () => dispatch(increaseAction)
    }
}

// Connected Component
const App = connect(
    mapStateToProps,
    mapDispatchToProps
)(Counter)

class CounterUI extends React.Component {
    render() {
        return (
            <Provider store={store}>
                <App />
            </Provider>
        )
    }
}

export default CounterUI