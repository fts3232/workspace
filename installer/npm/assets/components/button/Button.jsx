import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Button extends Component {
    render() {
        const { children, type, category } = this.props;
        return (
            <button type={type} className={this.classNames('btn', `btn-${ category }`)}>{children}</button>
        );
    }
}

Button.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    type    : PropTypes.string,
    category: PropTypes.string
};
Button.defaultProps = {
    type    : 'button',
    category: 'default'
};// 设置默认属性

// 导出组件
export default Button;