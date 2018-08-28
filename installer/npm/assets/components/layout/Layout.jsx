import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

const propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    children: PropTypes.any,
    hasSider: PropTypes.bool
};
const defaultProps = {
    children : {},
    hasSlider: false
};// 设置默认属性

class BasicLayout extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'siders': []
        };
    }

    render() {
        const { children, hasSider, prefixCls,  ...other } = this.props;
        return (
            <div
                className={this.classNames(prefixCls, {
                    [`${ prefixCls }-has-sider`]: hasSider || this.state.siders.length > 0
                })}
                {...other}
            >
                {children}
            </div>
        );
    }
}

BasicLayout.propTypes = propTypes;
BasicLayout.defaultProps = defaultProps;

class Basic extends Component {
    render() {
        const { prefixCls, children, ...other } = this.props;
        return (
            <div className={this.classNames(prefixCls)} {...other}>
                {children}
            </div>
        );
    }
}

Basic.propTypes = propTypes;
Basic.defaultProps = defaultProps;

function generator(baiscProps) {
    return (BasicComponent) => {
        const Adapter = class Adapter extends Component {
            constructor(props) {
                props = Object.assign(props, baiscProps);
                super(props);
            }

            render() {
                console.log(this);
                return (
                    <BasicComponent {...this.props}/>
                );
            }
        };
        return Adapter;
    };
}

const Header = generator({ prefixCls: 'layout-header' })(Basic);

const Content = generator({ prefixCls: 'layout-content' })(Basic);

const Footer = generator({ prefixCls: 'layout-footer' })(Basic);

const Layout = generator({ prefixCls: 'layout' })(BasicLayout);

Layout.Header = Header;
Layout.Footer = Footer;
Layout.Content = Content;

// 导出组件
export default Layout;