import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Col extends Component {
    render() {
        const { children, span } = this.props;
        return (
            <div className={this.classNames(`col-${ span }`)}>
                {children}
            </div>
        );
    }
}

Col.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    children: PropTypes.any,
    span    : PropTypes.oneOf([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]).isRequired
};
Col.defaultProps = {
    children: {}
};// 设置默认属性

// 导出组件
export default Col;