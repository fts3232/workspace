import React from 'react';
import { Link, Redirect, Route, Router, Switch } from 'react-router-dom';
import { createBrowserHistory } from 'history';

import Loader from '../components/loader';
import Component from '../components/component';
import Layout from '../components/layout';
import Menu from '../components/menu';
import Icon from '../components/icon';

import NotFound from './views/not-found';

import navs from './config/nav.js';

const { Header, Footer, Sider, Content } = Layout;
const { Item } = Menu;

class App extends Component {
    render() {
        const history = createBrowserHistory();
        let selectedKey = 0;
        navs.forEach((v, i) => {
            if (v.path === location.pathname || location.pathname.indexOf(v.path) !== -1) {
                selectedKey = i + 1;
            }
        });
        return (
            <Router history={history}>
                <Layout className='app'>
                    <Header>header</Header>
                    <Layout>
                        <Sider collapsible>
                            <Menu selectedKey={selectedKey}>
                                {navs.map((nav, key) => (
                                    <Item key={key}>
                                        <Link to={nav.path}>
                                            <Icon name={nav.icon}/><span>{nav.name}</span>
                                        </Link>
                                    </Item>
                                ))}
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
        );
    }
}

export default App;