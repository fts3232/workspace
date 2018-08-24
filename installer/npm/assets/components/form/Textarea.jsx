import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

class Textarea extends Component {
    render() {
        const { children, label, rows, placeholder } = this.props;
        return (
            <div className={style['form-group']}>
                <label className={this.classNames(style['label-control'], 'col-2')}>{label}</label>
                <div className='col-10'>
                    <textarea rows={rows} className={style['form-control']} defaultValue={children} placeholder={placeholder}/>
                </div>
            </div>
        );
    }
}

Textarea.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    label      : PropTypes.string.isRequired,
    rows       : PropTypes.number,
    placeholder: PropTypes.string,
    children   : PropTypes.any
};
Textarea.defaultProps = {
    rows       : 6,
    children   : '',
    placeholder: ''
};// 设置默认属性

// 导出组件
export default Textarea;