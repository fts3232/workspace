import React from 'react';
import ReactDOM from 'react-dom';
import { Redirect, Route, Router, Switch } from 'react-router-dom';
import { createBrowserHistory } from 'history';

import { Provider } from 'react-redux';
/* import Loader from './components/loader'; */

/* import Header from './site/views/header';
import Footer from './site/views/footer';
import NavBar from './site/views/nav-bar';
import NotFound from './site/views/not-found';
import nav from './site/config/nav.js'; */
import Layout from './components/layout';

import store from './store';

const { Header, Footer, Sider, Content } = Layout;
const history = createBrowserHistory();

// 加载style
const req = require.context('./components', true, /^\.\/[^_][\w-]+\/style\/main\.scss?$/);

// react-router
ReactDOM.render((
    <Router history={history}>
        <Provider store={store}>

            <Layout>
                <Header>header</Header>
                <Layout>
                    <Sider>left sidebar</Sider>
                    <Content>main content</Content>
                    <Sider>right sidebar</Sider>
                </Layout>
                <Footer>footer</Footer>
            </Layout>

        </Provider>
    </Router>
), document.getElementsByTagName('section')[0]);
