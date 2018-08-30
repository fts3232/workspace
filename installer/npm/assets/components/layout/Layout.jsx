import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

const propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    hasSider: PropTypes.bool
};
const defaultProps = {
    hasSider: false
};// 设置默认属性

class BasicLayout extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'siders': []
        };
    }

    getChildContext() {
        return {
            siderHook: {
                addSider: (id) => {
                    this.setState({
                        siders: [...this.state.siders, id]
                    });
                },
                removeSider: (id) => {
                    this.setState({
                        siders: this.state.siders.filter(currentId => currentId !== id)
                    });
                }
            }
        };
    }

    render() {
        const { children, hasSider, prefixCls, ...other } = this.props;
        return (
            <div
                {...other}
                className={this.classNames(prefixCls, {
                    [`${ prefixCls }-has-sider`]: hasSider || this.state.siders.length > 0
                })}
            >
                {children}
            </div>
        );
    }
}

BasicLayout.propTypes = propTypes;
BasicLayout.defaultProps = defaultProps;
BasicLayout.childContextTypes = {
    siderHook: PropTypes.object
};

class Basic extends Component {
    render() {
        const { prefixCls, children, hasSider, ...other } = this.props;
        return (
            <div {...other} className={this.classNames(prefixCls)}>
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
            render() {
                const props = Object.assign({}, this.props, baiscProps);
                return (
                    <BasicComponent {...props}/>
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