import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Button extends Component {
    constructor(props) {
        super(props);
        this.onClick = this.onClick.bind(this);
    }

    onClick(e) {
        const { onClick } = this.props;
        onClick(e);
    }

    render() {
        const { children, type } = this.props;
        return (
            <button onClick={this.onClick} className={this.classNames('btn', `btn-${ type }`)}>{children}</button>
        );
    }
}

Button.propTypes = { // 属性校验器，表示改属性必须是bool，否则报错
    type   : PropTypes.string,
    onClick: PropTypes.func
};
Button.defaultProps = {
    type   : 'default',
    onClick: () => {
    }
};// 设置默认属性

// 导出组件
export default Button;