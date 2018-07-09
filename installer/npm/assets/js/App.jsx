import React from 'react';
import PropTypes from 'prop-types';
import { Link } from "react-router-dom";
import css from '../css/style.css';
import img from '../images/a.jpg';
import { renderRoutes } from 'react-router-config'
import axios from 'axios'
import {connect} from "react-redux";
import CounterUI from "./components/Counter/CounterUI";

class App extends React.Component {
    constructor(props){
        super(props);
        this.state = {
            name:props.name
        }
    }
    fetch(){
        let _this = this;
        axios.get('http://localhost:3001/name')
            .then(function (response) {
                _this.setState({name:response.data})
                //console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
    componentDidMount(){
        console.log(this.state.name)
        if(!this.state.name){
            this.fetch();
        }
    }
    render() {
        let name = this.state.name;
        return (
            <div className="nav">
                <h2>Accounts</h2>
                <ul>
                    <li>
                        <Link to="/Counter">Counter</Link>
                    </li>
                    <li>
                        <a href="/Todo">Todo</a>
                    </li>
                </ul>
                <div>{name}</div>
                <img src={img} />
                {renderRoutes(this.props.route.routes)}
            </div>
        );
    }
}

App.propTypes={//属性校验器，表示改属性必须是bool，否则报错
    menu: PropTypes.array,
    name:PropTypes.string
}
App.defaultProps={
    menu:[],
    name:'',
    location:'',
    context:{}
};//设置默认属性


// Map Redux state to component props
function mapStateToProps(state) {
    return {
        name: state.name
    }
}

// Map Redux actions to component props
function mapDispatchToProps(dispatch) {
    return {}
}

// Connected Component
const AppUI = connect(
    mapStateToProps,
    mapDispatchToProps
)(App)

export default AppUI