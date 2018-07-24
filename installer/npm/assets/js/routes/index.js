// using an ES6 transpiler, like babel
import { matchRoutes, renderRoutes } from 'react-router-config'
import Loadable from 'react-loadable';
import App from '../App';
import Loading from '../components/Loading';
import React from 'react';

const Counter = Loadable({
    loader : () => import(/* webpackChunkName: "Counter" */'../components/Counter'),
    loading: Loading,
})

const Child = Loadable({
    loader : () => import(/* webpackChunkName: "Child" */'../components/Child'),
    loading: Loading,
})

const Todo = Loadable({
    loader : () => import(/* webpackChunkName: "Child" */'../components/Todo'),
    loading: Loading,
})

const routes = [
    {
        component: App,
        routes: [
            {
                path: '/Counter',
                exact: true,
                component: Counter
            },
            {
                path:'/Todo',
                exact:true,
                component:Todo
            }
        ]
    }
]

export default routes;