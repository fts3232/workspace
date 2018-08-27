import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Component from '../component';
import style from './style/main.scss';

class Label extends Component {
    render() {
        const { text } = this.props;
        return (
            <label className={this.classNames(style['label-control'])}>{text}</label>
        );
    }
}

Label.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    text: PropTypes.string.isRequired
};
Label.defaultProps = {
    text: ''
};// 设置默认属性

// 导出组件
export default Label;