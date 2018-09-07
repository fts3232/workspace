import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import Validator from './Validator.js';

class Form extends Component {
    constructor(props) {
        super(props);
        this.onSubmit = this.onSubmit.bind(this);
        this.state = {
            data : {},
            items: {}
        };
        this.form = null;
    }

    getChildContext() {
        return {
            setData: (name, value)=>{
                const { data } = this.state;
                this.setState({ data: Object.assign(data, { [`${ name }`]: value }) });
            },
            addItem: (name, component)=>{
                const { items } = this.state;
                this.setState({
                    items: Object.assign(items, { [`${ name }`]: component })
                });
            }
        };
    }

    submit() {
        let result;
        if (this.form.fireEvent) {
            // IE浏览器
            result = this.form.fireEvent('onsubmit');
        } else {
            // FIREFOX\CHROME等标准浏览器
            const evt = document.createEvent('HTMLEvents');
            evt.initEvent('submit', false, true);
            result = this.form.dispatchEvent(evt);
        }
        return result;
    }

    onSubmit(e) {
        e.preventDefault();
        const { onSubmit, validateRule, validateMsg } = this.props;
        const { data } = this.state;
        const validator = new Validator(data, validateRule, validateMsg);
        const { items } = this.state;
        if (!validator.isFail()) {
            Object.entries(items).map((v) => (
                v[1].setError('')
            ));
            onSubmit(data);
        } else {
            const error = validator.getError();
            Object.entries(items).map((v) => (
                v[1].setError(error[v[0]])
            ));
        }
        return false;
    }

    render() {
        const { children, action } = this.props;
        return (
            <form type={action} className={this.classNames('form')} onSubmit={this.onSubmit} ref={(form)=>{ this.form = form; }}>
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

Form.childContextTypes = {
    setData: PropTypes.func,
    addItem: PropTypes.func
};

// 导出组件
export default Form;