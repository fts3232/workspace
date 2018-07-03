import React from 'react';

import { StaticRouter } from "react-router-dom";
import { renderToString } from 'react-dom/server';

import routes from './routes/index.js';
import { renderRoutes } from 'react-router-config'

import Loadable from 'react-loadable';

function createApp(url, context) {
    let modules = [];
    let html = renderToString(
        <Loadable.Capture report={moduleName => modules.push(moduleName)}>
            <StaticRouter location={url} context={context}>
                {renderRoutes(routes)}
            </StaticRouter>
        </Loadable.Capture>
    )
    return { modules,html }
}

export default createApp;
