import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

class Row extends Component {
    render() {
        const { children } = this.props;
        return (
            <div className={style.row}>
                {children}
            </div>
        );
    }
}

Row.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    children: PropTypes.any
    gutter:PropTypes.number
};
Row.defaultProps = {
    children: {},
    gutter:0
};// 设置默认属性

// 导出组件
export default Row;