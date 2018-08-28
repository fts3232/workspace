import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Sider extends Component {
    render() {
        const { children } = this.props;
        return (
            <div className={this.classNames('layout-sider')}>
                {children}
            </div>
        );
    }
}

Sider.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    children        : PropTypes.any,
    collapsed       : PropTypes.bool,
    collapsible     : PropTypes.bool,
    defaultCollapsed: PropTypes.bool,
    collapsedWidth  : PropTypes.number,
    width           : PropTypes.number,
    onCollapse      : PropTypes.func
};
Sider.defaultProps = {
    children        : {},
    collapsed       : false,
    collapsible     : false,
    defaultCollapsed: false,
    collapsedWidth  : 64,
    width           : 200,
    onCollapse      : ()=>{}
};// 设置默认属性

// 导出组件
export default Sider;