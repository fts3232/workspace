import { Provider, connect } from 'react-redux'
import Counter from '../components/Counter';
import React from 'react';
import {increaseAction} from '../actions';

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

/*class Counter extends React.Component {
    render() {
        return (
            <Provider store={store}>
                <App />
            </Provider>
        )
    }
}*/

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(Counter)