import {combineReducers} from 'redux'
import count from './count'
import name from './name'
import todos from './todos';
import visibilityFilter from './visibilityFilter';

export default combineReducers({
    count,
    name,
    todos,
    visibilityFilter
})
