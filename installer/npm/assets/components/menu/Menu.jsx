import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Menu extends Component {
    constructor(props) {
        super(props);
        this.state = {
            selectedKey: props.selectedKey
        };
    }

    getChildContext() {
        return {
            selectedKey      : this.state.selectedKey,
            changeSelectedKey: (key) => {
                this.setState({ selectedKey: key });
            }
        };
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

Menu.propTypes = { // 属性校验器，表示改属性必须是bool，否则报错
    selectedKey: PropTypes.number
};
Menu.defaultProps = {
    selectedKey: 0
};// 设置默认属性

Menu.childContextTypes = {
    selectedKey      : PropTypes.number,
    changeSelectedKey: PropTypes.func
};

Menu.contextTypes = {
    siderCollapsed: PropTypes.bool,
    collapsedWidth: PropTypes.oneOfType([PropTypes.number, PropTypes.string])
};


// 导出组件
export default Menu;