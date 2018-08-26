import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Component from '../component';
import style from './style/main.scss';

class Textarea extends Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);
        const { value, setValue, name } = props;
        setValue(name, value);
    }

    onChange(e) {
        const { name, setValue } = this.props;
        setValue(name, e.target.value);
    }

    render() {
        const { value, label, rows, placeholder, error } = this.props;
        return (
            <div className={this.classNames(style['form-group'], { 'has-error': error })}>
                <label className={this.classNames(style['label-control'], 'col-2')}>{label}</label>
                <div className='col-10'>
                    <textarea rows={rows} className={style['form-control']} defaultValue={value} placeholder={placeholder} onChange={this.onChange}/>
                    {error ? (<p className="help-block">{error}</p>) : null}
                </div>
            </div>
        );
    }
}

Textarea.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    label      : PropTypes.string.isRequired,
    rows       : PropTypes.number,
    name       : PropTypes.string.isRequired,
    placeholder: PropTypes.string,
    value      : PropTypes.string,
    error      : PropTypes.string,
    setValue   : PropTypes.func
};
Textarea.defaultProps = {
    value      : '',
    rows       : 6,
    placeholder: '',
    error      : '',
    setValue   : () => {
    }
};// 设置默认属性

// 导出组件
const mapStateToProps = (state, ownProps) => {
    const { name } = ownProps;
    let { value, error } = ownProps;
    if (typeof state.formData.value[name] !== 'undefined') {
        value = state.formData.value[name];
    }
    if (typeof state.formData.error[name]) {
        error = state.formData.error[name];
    }
    return { error, value };
};

const mapDispatchToProps = (dispatch) => ({
    setValue: (name, value) => {
        const changeValue = {};
        changeValue[name] = value;
        dispatch({ type: 'SET_VALUE', changeValue });
    }
});

// 导出组件
export default connect(mapStateToProps, mapDispatchToProps)(Textarea);