import classnames from 'classnames';
import PropTypes from 'prop-types';
import React from 'react';

class Component extends React.Component {
    getParams(key) {
        const { router } = this.context;
        let { search } = router.route.location;
        if (search !== '') {
            search = search.substring(1);
            search = search.split('=');
            for (let i = 0; i < search.length; i += 2) {
                if (search[i] === key) {
                    return search[i + 1];
                }
            }
        }
        return null;
    }

    classNames(...args) {
        return classnames(...args);
    }

    style(args) {
        const { style } = this.props;
        return Object.assign({}, args, style);
    }
}

Component.propTypes = {
    style: PropTypes.object
};

Component.defaultProps = {
    style: {}
};// 设置默认属性

Component.contextTypes = {
    router: PropTypes.object
};

export default Component;