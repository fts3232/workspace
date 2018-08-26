import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Component from '../component';
import Validator from './Validator.js';

class Form extends Component {
    constructor(props) {
        super(props);
        this.onSubmit = this.onSubmit.bind(this);
    }

    onSubmit(e) {
        e.preventDefault();
        const { onSubmit, validateRule, validateMsg, value, setError } = this.props;
        console.log(value);
        const validator = new Validator(value, validateRule, validateMsg);
        if (!validator.isFail()) {
            onSubmit();
        } else {
            setError(validator.getError());
        }
        return false;
    }

    render() {
        const { children, action } = this.props;
        return (
            <form type={action} onSubmit={this.onSubmit}>
                {children}
            </form>
        );
    }
}

Form.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    action      : PropTypes.string,
    onSubmit    : PropTypes.func,
    children    : PropTypes.any,
    validateRule: PropTypes.object,
    validateMsg : PropTypes.object,
    value       : PropTypes.object,
    setError    : PropTypes.func
};
Form.defaultProps = {
    action  : 'post',
    children: {},
    onSubmit: () => {
    },
    validateRule: {},
    validateMsg : {},
    value       : {},
    setError    : ()=>{}
};// 设置默认属性

// 导出组件
const mapStateToProps = (state) => {
    const { value } = state.formData;
    return { value };
};

const mapDispatchToProps = (dispatch) => ({
    setError: (error) => {
        dispatch({ type: 'SET_VALUE', error });
    }
});

export default connect(mapStateToProps, mapDispatchToProps)(Form);