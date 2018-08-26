import { createStore, combineReducers, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';
import * as components from './components/reducer.js';

const store = createStore(
    combineReducers({ ...components }),
    applyMiddleware(thunk)
);

export default store;