import React from 'react';
import PropTypes from 'prop-types';
import { Provider } from 'react-redux';
import { createStore } from 'redux';
import Component from '../component';
import Validator from './Validator.js';
import reducer from './reducer.js';

class Form extends Component {
    constructor(props) {
        super(props);
        this.onSubmit = this.onSubmit.bind(this);
        this.store = createStore(reducer);
    }

    onSubmit(e) {
        e.preventDefault();
        const { onSubmit, validateRule, validateMsg } = this.props;
        const { data }  = this.store.getState();
        const validator = new Validator(data, validateRule, validateMsg);
        if (!validator.isFail()) {
            onSubmit(data);
        } else {
            this.store.dispatch({ 'type': 'SET_ERROR', error: validator.getError() });
        }
        return false;
    }

    render() {
        const { children, action } = this.props;
        return (
            <Provider store={this.store}>
                <form type={action} className={this.classNames('form')} onSubmit={this.onSubmit}>
                    {children}
                </form>
            </Provider>
        );
    }
}

Form.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    action      : PropTypes.string,
    name        : PropTypes.string,
    onSubmit    : PropTypes.func,
    validateRule: PropTypes.object,
    validateMsg : PropTypes.object,
    value       : PropTypes.object
};
Form.defaultProps = {
    action  : 'post',
    name    : '',
    onSubmit: () => {
    },
    validateRule: {},
    validateMsg : {},
    value       : {}
};// 设置默认属性

// 导出组件
export default Form;