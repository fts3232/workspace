import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

require('./font.js');

class IconButton extends Component {
    render() {
        const { name } = this.props;
        return (
            <svg className={style.icon} aria-hidden="true">
                <use xlinkHref={`#icon-${ name }`}/>
            </svg>
        );
    }
}

IconButton.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    name: PropTypes.string.isRequired
};
IconButton.defaultProps = {};// 设置默认属性

// 导出组件
export default IconButton;