// using an ES6 transpiler, like babel
import Loadable from 'react-loadable';
import App from '../components/App';
import Loading from '../components/Loading';

const Counter = Loadable({
    loader: () => import(/* webpackChunkName: "Counter" */ '../components/Counter'),
    loading: Loading,
});

const Child = Loadable({
    loader: () => import(/* webpackChunkName: "Child" */ '../components/Child'),
    loading: Loading,
});

/* const TodoList = Loadable({
    loader: () => import(/!* webpackChunkName: "Child" *!/ '../components/Todo/components/App'),
    loading: Loading,
}); */

const routes = [
    {
        component: App,
        routes: [
            {
                path: '/Counter',
                exact: true,
                component: Counter,
            },
            /* {
                path: '/Todo',
                exact: true,
                component: TodoList,
            }, */
            {
                path: '/:id',
                exact: true,
                component: Child,
            },
        ],
    },
];

export default routes;
