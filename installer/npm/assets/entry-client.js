import React from 'react';
import ReactDOM from 'react-dom';
import { Redirect, Route, Router, Switch, Link } from 'react-router-dom';
import { createBrowserHistory } from 'history';

import Loader from './components/loader';
import NotFound from './site/views/not-found';

/* import nav from './site/config/nav.js'; */
import Layout from './components/layout';
import Menu from './components/menu';
import Icon from './components/icon';

/* import store from './store'; */

const { Header, Footer, Sider, Content } = Layout;
const { Item } = Menu;
const history = createBrowserHistory();

// 加载style
require.context('./components', true, /^\.\/[^_][\w-]+\/style\/main\.scss?$/);
require.context('./site/style', true, /^\.\/[\w-]+\.scss?$/);

// react-router
ReactDOM.render((
    <Router history={history}>
        <Layout className='app'>
            <Header>header</Header>
            <Layout>
                <Sider collapsible>
                    <Menu selectedKeys={1}>
                        <Item>
                            <Link to="/cash-book">
                                <Icon name='desktop'/><span>账簿</span>
                            </Link>
                        </Item>
                    </Menu>
                </Sider>
                <Layout>
                    <Content>
                        <Switch>
                            <Route
                                path="/"
                                exact
                                render={() => (
                                    <Redirect to="/cash-book"/>
                                )}
                            />
                            <Route exact strict path="/:controller/:action?" component={Loader}/>
                            <Route component={NotFound}/>
                        </Switch>
                    </Content>
                    <Footer>footer</Footer>
                </Layout>
            </Layout>
        </Layout>
    </Router>
), document.getElementsByTagName('section')[0]);
