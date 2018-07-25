// using an ES6 transpiler, like babel
import { matchRoutes, renderRoutes } from 'react-router-config'
import Loadable from 'react-loadable';
import App from '../components/App';
import Loading from '../components/Loading';
import React from 'react';

const Counter = Loadable({
    loader : () => import(/* webpackChunkName: "Counter" */'../containers/Counter'),
    loading: Loading,
})

const Child = Loadable({
    loader : () => import(/* webpackChunkName: "Child" */'../components/Child'),
    loading: Loading,
})

const TodoList = Loadable({
    loader : () => import(/* webpackChunkName: "Child" */'../components/Todo/components/App'),
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
                component:TodoList
            }
        ]
    }
]

export default routes;