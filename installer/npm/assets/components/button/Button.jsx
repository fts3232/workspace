import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

class Button extends Component {
    render() {
        const { children, type, category } = this.props;
        return (
            <button type={type} className={this.classNames(style.btn, style[`btn-${ category }`])}>{children}</button>
        );
    }
}

Button.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    type    : PropTypes.string,
    category: PropTypes.string,
    children: PropTypes.any
};
Button.defaultProps = {
    type    : 'button',
    category: 'default',
    children: {}
};// 设置默认属性

// 导出组件
export default Button;