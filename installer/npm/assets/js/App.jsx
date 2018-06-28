import React from 'react';
import PropTypes from 'prop-types';
import { Link } from "react-router-dom";
import css from '../css/style.css';
import img from '../images/a.jpg';
import { renderRoutes } from 'react-router-config'

class App extends React.Component {
    constructor(props){
        super(props);
    }
    getMenu(){
        return this.props.menu;
    }
    render() {
        return (
            <div className="nav">
                <h2>Accounts</h2>
                <ul>
                    <li>
                        <Link to="/Counter">Counter</Link>
                    </li>
                    <li>
                        <Link to="/Todo">Todo</Link>
                    </li>
                </ul>
                <img src={img} />
                {renderRoutes(this.props.route.routes)}
            </div>
        );
    }
}

App.propTypes={//属性校验器，表示改属性必须是bool，否则报错
    menu: PropTypes.array
}
App.defaultProps={
    menu:[],
    location:'',
    context:{}
};//设置默认属性

export default App