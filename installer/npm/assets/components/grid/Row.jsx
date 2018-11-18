import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Row extends Component {
    getChildContext() {
        const { gutter } = this.props;
        return { gutter };
    }

    render() {
        const { children, gutter } = this.props;
        let style = {};
        if (gutter > 0) {
            style = { marginLeft: `-${ gutter / 2  }px`, marginRight: `-${ gutter / 2  }px` };
        }
        return (
            <div className={this.classNames('row')} style={this.style(style)}>
                {children}
            </div>
        );
    }
}

Row.childContextTypes = {
    gutter: PropTypes.number
};
Row.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    children: PropTypes.any,
    gutter  : PropTypes.number
};
Row.defaultProps = {
    children: {},
    gutter  : 0
};// 设置默认属性

// 导出组件
export default Row;