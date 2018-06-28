import React from 'react';
import { hot } from 'react-hot-loader'
import PropTypes from 'prop-types';
import { Route, Link } from "react-router-dom";
import css from '../css/style.css';
import img from '../images/a.jpg';


class Root extends React.Component {
    constructor(props){
        super(props);
    }
    getMenu(){
        return this.props.menu;
    }
    render() {
        let Router = this.props.router
        return (
            <Router location={this.props.location} context={this.props.context}>
                <div className="nav">
                    <h2>Accounts</h2>
                    <ul>
                        <li>
                            <Link to="/Counter">Counter</Link>
                        </li>
                        <li>
                            <Link to="/Counter/Todo">Todo</Link>
                        </li>
                    </ul>
                    <img src={img} />
                    <Route path="/Counter" component={LoadableComponent} />
                    <Route path="/Counter/Todo" component={Child} />
                </div>
            </Router>
        );
    }
}

Root.propTypes={//属性校验器，表示改属性必须是bool，否则报错
    menu: PropTypes.array
}
Root.defaultProps={
    menu:[],
    location:'',
    context:{}
};//设置默认属性

const Child = ({ match }) => (
    <div>
        <h3>ID: {match.params.id}</h3>
    </div>
);

export default hot(module)(App)