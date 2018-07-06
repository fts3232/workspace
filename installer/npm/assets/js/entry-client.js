import React from 'react';
import ReactDOM from 'react-dom';

import { BrowserRouter } from "react-router-dom";

import routes from './routes';
import { renderRoutes } from 'react-router-config'

import Loadable from 'react-loadable';

if (IS_SERVER_RENDER) {
    Loadable.preloadReady().then(() => {
        //ssr用hydrate() 普通用render()
        ReactDOM.hydrate(
            <BrowserRouter>
                {renderRoutes(routes)}
            </BrowserRouter>,
            document.getElementById('app')
        )
    });
} else {
    ReactDOM.render(
        <BrowserRouter>
            {renderRoutes(routes)}
        </BrowserRouter>,
        document.getElementById('app')
    )
}