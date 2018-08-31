import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

const generateId = (() => {
    let i = 0;
    return () => {
        i += 1;
        return i;
    };
})();

class MenuItem extends Component {

    constructor(props) {
        super(props);
        this.uniqueId = generateId('menu-item-');
        this.onClick = this.onClick.bind(this);
    }

    onClick() {
        const { changeSelectedKey } = this.context;
        changeSelectedKey(this.uniqueId);
    }

    render() {
        const { children } = this.props;
        const { selectedKey } = this.context;
        return (
            <li role="menuitem" className={this.classNames('menu-item', { 'menu-item-selected': selectedKey === this.uniqueId })} onClick={this.onClick}>
                {children}
            </li>
        );
    }
}

MenuItem.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
};
MenuItem.defaultProps = {};// 设置默认属性

MenuItem.contextTypes = {
    selectedKey      : PropTypes.number,
    changeSelectedKey: PropTypes.func
};

// 导出组件
export default MenuItem;