import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import isNumeric from '../_util/isNumeric';
import Icon from '../icon';

const generateId = (() => {
    let i = 0;
    return (prefix = '') => {
        i += 1;
        return `${ prefix }${ i }`;
    };
})();

class Sider extends Component {
    constructor(props) {
        super(props);
        this.uniqueId = generateId('sider-');
        this.state = {
            collapsed: props.collapsed
        };
        this.toggle = this.toggle.bind(this);
    }

    getChildContext() {
        return {
            siderCollapsed: this.state.collapsed,
            collapsedWidth: this.props.collapsedWidth
        };
    }

    componentDidMount() {
        if (this.context.siderHook) {
            this.context.siderHook.addSider(this.uniqueId);
        }
    }

    componentWillUnmount() {
        if (this.context.siderHook) {
            this.context.siderHook.removeSider(this.uniqueId);
        }
    }

    setCollapsed(collapsed, type) {
        this.setState({
            collapsed
        });
        const { onCollapse } = this.props;
        if (onCollapse) {
            onCollapse(collapsed, type);
        }
    }

    toggle() {
        const collapsed = !this.state.collapsed;
        this.setCollapsed(collapsed, 'clickTrigger');
    }

    render() {
        const { children, width, collapsedWidth, prefixCls, collapsible } = this.props;
        const rawWidth = this.state.collapsed ? collapsedWidth : width;
        // use "px" as fallback unit for width
        const siderWidth = isNumeric(rawWidth) ? `${ rawWidth }px` : String(rawWidth);
        const divStyle = {
            flex    : `0 0 ${ siderWidth }`,
            maxWidth: siderWidth, // Fix width transition bug in IE11
            minWidth: siderWidth, // https://github.com/ant-design/ant-design/issues/6349
            width   : siderWidth
        };
        return (
            <div className={this.classNames(prefixCls)} style={this.style(divStyle)}>
                <div className={`${ prefixCls }-sider-children`}>
                    {children}
                </div>
                {collapsible ? (
                    <div className={`${ prefixCls }-trigger`} role="button" onClick={this.toggle} style={{ width: siderWidth }}>
                        {this.state.collapsed ? (<Icon name="left"/>) : (<Icon name="right"/>)}
                    </div>
                ) : null}
            </div>
        );
    }
}

Sider.propTypes = { // 属性校验器，表示改属性必须是bool，否则报错
    collapsed     : PropTypes.bool, // 当前收起状态
    collapsible   : PropTypes.bool, // 是否可收起
    collapsedWidth: PropTypes.number, // 收起宽度
    width         : PropTypes.number,
    onCollapse    : PropTypes.func,
    prefixCls     : PropTypes.string
};
Sider.defaultProps = {
    collapsed     : false,
    collapsible   : false,
    collapsedWidth: 64,
    width         : 200,
    onCollapse    : () => {
    },
    prefixCls: 'layout-sider'
};// 设置默认属性

Sider.childContextTypes = {
    siderCollapsed: PropTypes.bool,
    collapsedWidth: PropTypes.oneOfType([PropTypes.number, PropTypes.string])
};

Sider.contextTypes = {
    siderHook: PropTypes.object
};

// 导出组件
export default Sider;