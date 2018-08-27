import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

class Col extends Component {
    render() {
        const { children, span, align } = this.props;
        return (
            <div className={style[`col-${ span }`]}>
                {children}
            </div>
        );
    }
}

Col.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    children: PropTypes.any,
    span    : PropTypes.oneOf([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]).isRequired,
    align   : PropTypes.oneOf(['left', 'right', 'center'])
};
Col.defaultProps = {
    children: {},
    align   : 'left'
};// 设置默认属性

// 导出组件
export default Col;