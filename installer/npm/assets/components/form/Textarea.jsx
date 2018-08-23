import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

class Textarea extends Component {
    render() {
        const { children, label, rows } = this.props;
        return (
            <div className={style['form-group']}>
                <label className={this.classNames(style['label-control'], 'col-2')}>{label}</label>
                <textarea rows={rows} className={this.classNames(style['form-control'], 'col-10')}>{children}</textarea>
            </div>
        );
    }
}

Textarea.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    label   : PropTypes.string.isRequired,
    rows    : PropTypes.number,
    children: PropTypes.object
};
Textarea.defaultProps = {
    rows    : 6,
    children: {}
};// 设置默认属性

// 导出组件
export default Textarea;