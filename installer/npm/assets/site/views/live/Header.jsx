import React from 'react';
import PropTypes from 'prop-types';
import Component from '../../../components/component';

class Header extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'loading': false
        };
    }

    parent() {
        return this.context.component;
    }

    update() {
        if (!this.state.loading) {
            this.setState({ 'loading': true });
            this.parent().updateData();
        }
    }

    render() {
        return (
            <div className="header">
                <button className={this.classNames({ 'loading': this.state.loading })} onClick={this.update.bind(this)}>{this.state.loading ? '加载中' : '更新数据'}</button>
            </div>
        );
    }
}

Header.contextTypes = {
    component: PropTypes.any
};

Header.propTypes = {};

Header.defaultProps = {};

// 导出组件
export default Header;