import React from 'react';
import { Link, Redirect, Route, Router, Switch } from 'react-router-dom';
import { createBrowserHistory } from 'history';

import Loader from '../components/loader';
import Component from '../components/component';
import Layout from '../components/layout';
import Menu from '../components/menu';
import Icon from '../components/icon';

import NotFound from './views/not-found';

import navMenu from './config/navMenu.js';

const { Header, Footer, Sider, Content } = Layout;
const { Item, SubMenu } = Menu;

class App extends Component {
    getMenu(menu, key, depth = 0) {
        if (typeof menu.child !== 'undefined') {
            return (
                <SubMenu title={<span><Icon name={menu.icon}/><span>{menu.name}</span></span>} key={key}>
                    {menu.child.map((child, k) => this.getMenu(child, k, depth + 1))}
                </SubMenu>
            );
        }
        return (
            <Item style={depth > 0 && { paddingLeft: depth * 48 }} key={key}>
                <Link to={menu.path}>
                    {typeof menu.icon !== 'undefined' && <Icon name={menu.icon}/>}<span>{menu.name}</span>
                </Link>
            </Item>
        );
    }

    getCurrentMenu(menus) {
        let selectedKey = 0;
        menus.forEach((menu, i) => {
            if (menu.path === location.pathname || location.pathname.indexOf(menu.path) !== -1) {
                selectedKey = i + 1;
            }
            if (typeof menu.child !== 'undefined') {
                selectedKey = this.getCurrentMenu(menu.child);
            }
        });
        return selectedKey;
    }

    render() {
        const history = createBrowserHistory();
        const selectedKey = this.getCurrentMenu(navMenu);
        return (
            <Router history={history}>
                <Layout className='app'>
                    <Header>header</Header>
                    <Layout>
                        <Sider collapsible>
                            <Menu selectedKey={selectedKey}>
                                {navMenu.map((menu, key) => this.getMenu(menu, key))}
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