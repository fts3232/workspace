import React from 'react';

import { StaticRouter } from "react-router-dom";
import { renderToString } from 'react-dom/server';

import routes from './routes/index.js';
import { renderRoutes } from 'react-router-config'

import Loadable from 'react-loadable';
import axios from 'axios';
import { createStore } from 'redux'
import { Provider, connect } from 'react-redux'
import { getBundles } from 'react-loadable/webpack'
import cheerio from 'cheerio';

function createApp(url, store) {
    let modules = [];
    let context = {};

    let html = renderToString(
        <Loadable.Capture report={moduleName => modules.push(moduleName)}>
            <Provider store={store}>
                <StaticRouter location={url} context={context}>
                    {renderRoutes(routes)}
                </StaticRouter>
            </Provider>
        </Loadable.Capture>
    )
    return {modules, html}
}

export default createApp;
