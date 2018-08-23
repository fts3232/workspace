import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

class Select extends Component {
    render() {
        const { label, data, value } = this.props;
        const options = Object.entries(data).map((v) => {
            if (value === v[0]) {
                return (<option value={v[0]} selected="selected">{v[1]}</option>);
            } 
            return (<option value={v[0]}>{v[1]}</option>);
            
        });
        return (
            <div className={style['form-group']}>
                <label className={this.classNames(style['label-control'], 'col-2')}>{label}</label>
                <select className={this.classNames(style['form-control'], 'col-10')}>
                    {options}
                </select>
            </div>
        );
    }
}

Select.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    label: PropTypes.string.isRequired,
    data : PropTypes.object.isRequired,
    value: PropTypes.string
};
Select.defaultProps = {
    value: null
};// 设置默认属性

// 导出组件
export default Select;