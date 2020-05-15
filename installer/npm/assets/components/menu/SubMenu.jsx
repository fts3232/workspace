import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import Icon from '../icon';

class SubMenu extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'collapse': true
        };
        this.onClick = this.onClick.bind(this);
    }

    getChildContext() {
        return {
            open: () => {
                this.setState({ 'collapse': false });
            }
        };
    }

    onClick() {
        const { collapse } = this.state;
        this.setState({ 'collapse': !collapse });
    }

    render() {
        const { children, title } = this.props;
        const { collapse } = this.state;
        const icon = collapse ? 'down' : 'up';
        return (
            <li className={this.classNames('menu-submenu', { 'menu-submenu-collapse': collapse })}>
                <div className="menu-submenu-title" role="button" onClick={this.onClick}>{title}<Icon className="collapse" name={icon}/></div>
                <ul>
                    {children}
                </ul>
            </li>
        );
    }
}

SubMenu.propTypes = { // 属性校验器，表示改属性必须是bool，否则报错
    title: PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired
};
SubMenu.defaultProps = {};// 设置默认属性

SubMenu.childContextTypes = {
    open: PropTypes.func
};

// 导出组件
export default SubMenu;