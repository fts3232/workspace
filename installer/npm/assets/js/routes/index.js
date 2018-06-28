// using an ES6 transpiler, like babel
import {matchRoutes, renderRoutes} from 'react-router-config'
import Loadable from 'react-loadable';
import App from '../App.jsx';
import Loading from '../components/Loading.jsx';
import React from 'react';

const LoadableComponent = Loadable({
    loader : () => import(/* webpackChunkName: "lazy" */'../components/Counter.jsx'),
    loading: Loading,
})


const Child = ({ match }) => (
    <div>
        <h3>ID: {match.params.id}</h3>
    </div>
);

const routes = [
    { component: App,
        routes: [
            { path: '/Counter',
                exact: true,
                component: LoadableComponent
            },
            { path: '/Todo',
                exact: true,
                component: Child,
            }
        ]
    }
]

export default routes;