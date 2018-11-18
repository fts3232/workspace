import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Col extends Component {
    render() {
        const { children, span, offset } = this.props;
        const { gutter } = this.context;
        let style = {};
        if (gutter > 0) {
            style = { paddingLeft: `${  gutter / 2  }px`, paddingRight: `${  gutter / 2  }px` };
        }
        return (
            <div className={this.classNames(`col-${ span }`, { [`col-offset-${ offset }`]: offset !== 0 })} style={this.style(style)}>
                {children}
            </div>
        );
    }
}
Col.contextTypes = {
    gutter: PropTypes.number
};
Col.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    span  : PropTypes.oneOf([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]).isRequired,
    offset: PropTypes.oneOf([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
    space : PropTypes.number
};
Col.defaultProps = {
    offset: 0,
    space : 0
};// 设置默认属性

// 导出组件
export default Col;