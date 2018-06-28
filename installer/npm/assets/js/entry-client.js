import React from 'react';
import ReactDOM from 'react-dom';
import App from './App.jsx';
import Counter from './components/Counter.jsx';
import { BrowserRouter } from "react-router-dom";
import { createStore } from 'redux'
import { Provider, connect } from 'react-redux'
import routes from './routes/index.js';
import { renderRoutes } from 'react-router-config'
import Loadable from 'react-loadable';

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
/*const App = connect(
    mapStateToProps,
    mapDispatchToProps
)(Counter)*/



Loadable.preloadReady().then(() => {
    ReactDOM.hydrate(
        <BrowserRouter>
            {renderRoutes(routes)}
        </BrowserRouter>,
        document.getElementById('app')
    )
});