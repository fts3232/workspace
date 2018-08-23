import React from 'react';
import ReactDOM from 'react-dom';
import { Redirect, Route, Router, Switch } from 'react-router-dom';
import { createBrowserHistory } from 'history';
import superagent from 'superagent';

import Loader from './components/loader';

import style from './site/style/main.scss';
import Header from './site/views/header';
import Footer from './site/views/footer';
import NavBar from './site/views/nav-bar';
import NotFound from './site/views/not-found';
import nav from './site/config/nav.js';

const history = createBrowserHistory();
window.request = superagent;
// react-router

ReactDOM.render((
    <Router history={history}>
        <div className={style.app}>
            <Header/>
            <NavBar data={nav}/>
            <div className={style['content-container']}>
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
            </div>
            <Footer/>
        </div>
    </Router>
), document.getElementsByTagName('section')[0]);
