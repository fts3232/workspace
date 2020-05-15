import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

require('./font.js');

class Icon extends Component {
    constructor(props) {
        super(props);
        this.onClick = props.onClick.bind(this);
    }

    render() {
        const { name } = this.props;
        return (
            <svg className={this.classNames('icon')} aria-hidden="true" onClick={this.onClick}>
                <use xlinkHref={`#icon-${ name }`}/>
            </svg>
        );
    }
}

Icon.propTypes = { // 属性校验器，表示改属性必须是bool，否则报错
    name   : PropTypes.string.isRequired,
    onClick: PropTypes.func
};
Icon.defaultProps = {
    onClick: () => {
    }
};// 设置默认属性

// 导出组件
export default Icon;