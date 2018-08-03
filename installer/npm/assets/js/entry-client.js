import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter } from 'react-router-dom';
import { renderRoutes } from 'react-router-config';
import Loadable from 'react-loadable';
import { Provider } from 'react-redux';
import { createStore } from 'redux';
import routes from './routes';

if (typeof IS_SERVER_RENDER !== 'undefined') {
    const preloadedState = window.PRELOADED_STATE;

    // 使用初始 state 创建 Redux store
    const store = createStore ((state = { name: '', count: 0 }, action) => {
        const { count } = state;
        switch (action.type) {
            case 'increase':
                return { count: count + 1 };
            default:
                return state;
        }
    }, preloadedState);

    Loadable.preloadReady ().then (() => {
        // ssr用hydrate() 普通用render()
        ReactDOM.hydrate (
            <BrowserRouter>
                <Provider store={store}>
                    {renderRoutes (routes)}
                </Provider>
            </BrowserRouter>,
            document.getElementById ('app')
        );
    });
} else {
    const store = createStore ();
    ReactDOM.render (
        <BrowserRouter>
            <Provider store={store}>
                {renderRoutes (routes)}
            </Provider>
        </BrowserRouter>,
        document.getElementById ('app')
    );
}
