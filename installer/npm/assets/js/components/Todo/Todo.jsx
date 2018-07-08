import React from 'react';
import PropTypes from 'prop-types';
import axios from "../../../../node_modules/.0.18.0@axios";
class Todo extends React.Component {
    constructor(props){
        super(props);
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
        return (
            <li
                onClick={onClick}
                style={ {
                    textDecoration: completed ? 'line-through' : 'none'
                }}
            >
                {text}
            </li>
        );
    }
}

Todo.propTypes={//属性校验器，表示改属性必须是bool，否则报错
    onClick: PropTypes.func.isRequired,
    completed: PropTypes.bool.isRequired,
    text: PropTypes.string.isRequired
}
Todo.defaultProps={

};//设置默认属性

export default Todo