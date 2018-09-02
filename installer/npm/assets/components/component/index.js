import classnames from 'classnames';
import PropTypes from 'prop-types';
import React from 'react';

class Component extends React.Component {
    getParams(key, defaultValue = null) {
        const { location } = this.props;
        let { search } = location;
        if (search !== '') {
            search = search.substring(1);
            search = search.split('=');
            for (let i = 0; i < search.length; i += 2) {
                if (search[i] === key) {
                    return search[i + 1];
                }
            }
        }
        return defaultValue;
    }

    classNames(...args) {
        const { className } = this.props;
        return classnames(...args, className);
    }

    style(args) {
        const { style } = this.props;
        return Object.assign({}, args, style);
    }
}

Component.propTypes = {
    children : PropTypes.any,
    style    : PropTypes.object,
    className: PropTypes.string
};

Component.defaultProps = {
    style    : {},
    className: '',
    children : {}
};// 设置默认属性

Component.contextTypes = {
    router: PropTypes.object
};

export default Component;