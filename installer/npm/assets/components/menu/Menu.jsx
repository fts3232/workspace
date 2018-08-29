import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Menu extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const { children } = this.props;
        const { siderCollapsed } = this.context;
        return (
            <ul className={this.classNames('menu', { 'menu-collapsed': siderCollapsed })}>
                {children}
            </ul>
        );
    }
}

Menu.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错

};
Menu.defaultProps = {};// 设置默认属性

Menu.contextTypes = {
    siderCollapsed: PropTypes.bool,
    collapsedWidth: PropTypes.oneOfType([PropTypes.number, PropTypes.string])
};


// 导出组件
export default Menu;