import React from 'react';
import ReactDOM from 'react-dom';

import { BrowserRouter,StaticRouter } from "react-router-dom";

import routes from './routes';
import { renderRoutes } from 'react-router-config'

import Loadable from 'react-loadable';
import { Provider, connect } from 'react-redux'
import { createStore } from 'redux'
import Todo from './components/Todo/index.js';



if (IS_SERVER_RENDER) {

    const preloadedState = window.__PRELOADED_STATE__

    // 使用初始 state 创建 Redux store
    const store = createStore((state = { name: '',count:0 }, action) => {
        const name = state.name
        const count = state.count
        switch (action.type) {
            case 'increase':
                return { count: count + 1 }
            default:
                return state
        }
    }, preloadedState)

    Loadable.preloadReady().then(() => {
        //ssr用hydrate() 普通用render()
        ReactDOM.hydrate(
            <BrowserRouter>
                <Provider store={store}>
                    {renderRoutes(routes)}
                </Provider>
            </BrowserRouter>,
            document.getElementById('app')
        )
    });
} else {
    /*const store = createStore((state = { name: '',count:0 }, action) => {
        const name = state.name
        const count = state.count
        switch (action.type) {
            case 'increase':
                return { count: count + 1 }
            default:
                return state
        }
    })

    ReactDOM.render(
        <BrowserRouter>
            <Provider store={store}>
                {renderRoutes(routes)}
            </Provider>
        </BrowserRouter>,
        document.getElementById('app')
    )*/
}