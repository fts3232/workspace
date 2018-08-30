import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import Validator from './Validator.js';

class Form extends Component {
    constructor(props) {
        super(props);
        this.onSubmit = this.onSubmit.bind(this);
        this.state = {
            'data': {}
        };
    }


    getChildContext() {
        return {
            setData: this.setData.bind(this)
        };
    }

    onSubmit(e) {
        e.preventDefault();
        const { onSubmit, validateRule, validateMsg, setError } = this.props;
        const { data } = this.state;
        console.log(data);
        const validator = new Validator(data, validateRule, validateMsg);
        if (!validator.isFail()) {
            onSubmit();
        } else {
            setError(validator.getError());
        }
        return false;
    }

    setData(name, value) {
        const { data } = this.state;
        const obj = {};
        console.log(data);
        obj[name] = value;
        console.log({ ...data, ...obj });
        this.setState({ data: { ...data, ...obj } }, ()=>{
            console.log(1);
            console.log(this.state);
        });
    }

    render() {
        const { children, action } = this.props;
        return (
            <form type={action} className={this.classNames('form')} onSubmit={this.onSubmit}>
                {children}
            </form>
        );
    }
}

Form.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    action      : PropTypes.string,
    name        : PropTypes.string,
    onSubmit    : PropTypes.func,
    validateRule: PropTypes.object,
    validateMsg : PropTypes.object,
    value       : PropTypes.object,
    setError    : PropTypes.func
};
Form.defaultProps = {
    action  : 'post',
    name    : '',
    onSubmit: () => {
    },
    validateRule: {},
    validateMsg : {},
    value       : {},
    setError    : () => {
    }
};// 设置默认属性

Form.childContextTypes = {
    setData: PropTypes.func
};

// 导出组件
export default Form;