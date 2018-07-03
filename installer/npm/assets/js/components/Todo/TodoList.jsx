import React from 'react';
import PropTypes from 'prop-types';
import Todo from './Todo'
class TodoList extends React.Component {
    constructor(props){
        super(props);
    }
    render() {
        return (
            <ul>
                {todos.map(todo => (
                    <Todo key={todo.id} {...todo} onClick={() => onTodoClick(todo.id)} />
                ))}
            </ul>
        );
    }
}

TodoList.propTypes={//属性校验器，表示改属性必须是bool，否则报错
    todos: PropTypes.arrayOf(
        PropTypes.shape({
            id: PropTypes.number.isRequired,
            completed: PropTypes.bool.isRequired,
            text: PropTypes.string.isRequired
        }).isRequired
    ).isRequired,
    onTodoClick: PropTypes.func.isRequired
}
TodoList.defaultProps={
    
};//设置默认属性

export default Todo