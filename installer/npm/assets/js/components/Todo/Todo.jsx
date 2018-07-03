import React from 'react';
import PropTypes from 'prop-types';
class Todo extends React.Component {
    constructor(props){
        super(props);
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