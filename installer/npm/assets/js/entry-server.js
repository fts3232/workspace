import React from 'react';
//import App from './App.jsx';
import Counter from './components/Counter.jsx';
import { StaticRouter } from "react-router-dom";
import { renderToString } from 'react-dom/server';

import { createStore } from 'redux'
import { Provider, connect } from 'react-redux'
import routes from './routes/index.js';
import { renderRoutes } from 'react-router-config'

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

// Action
const increaseAction = { type: 'increase' }

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

function createApp(url, context) {
    const store = createStore(counter);
    return renderToString(
        <StaticRouter location={url} context={context}>
            {renderRoutes(routes)}
        </StaticRouter>
    )
}

export default createApp;
