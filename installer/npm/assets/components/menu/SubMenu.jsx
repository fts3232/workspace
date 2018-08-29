import React from 'react';
import Component from '../component';

class SubMenu extends Component {
    render() {
        const { children } = this.props;
        return (
            <li className={this.classNames('menu-submenu')}>
                <div className="menu-submenu-title"/>
                {children}
            </li>
        );
    }
}

SubMenu.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
};
SubMenu.defaultProps = {};// 设置默认属性

// 导出组件
export default SubMenu;