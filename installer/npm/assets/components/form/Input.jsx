import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Component from '../component';
import style from './style/main.scss';

class Input extends Component {
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
        const { label, type, value, readonly, placeholder, error, name } = this.props;
        return (
            <div className={this.classNames(style['form-group'], { 'has-error': error })}>
                <input
                    className={this.classNames(style['form-control'])}
                    name={name}
                    type={type}
                    placeholder={placeholder}
                    readOnly={readonly}
                    defaultValue={value}
                    onChange={this.onChange}
                />
                {error ? (<p className="help-block">{error}</p>) : null}
            </div>
        );
    }
}

Input.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    label      : PropTypes.string.isRequired,
    name       : PropTypes.string.isRequired,
    type       : PropTypes.string,
    placeholder: PropTypes.string,
    readonly   : PropTypes.bool,
    value      : PropTypes.string,
    error      : PropTypes.string,
    setValue   : PropTypes.func
};
Input.defaultProps = {
    type       : 'text',
    value      : '',
    readonly   : false,
    placeholder: '',
    error      : '',
    setValue   : () => {
    }
};// 设置默认属性

// 导出组件
const mapStateToProps = (state, ownProps) => {
    const { name } = ownProps;
    let { value, error } = ownProps;
    if (typeof state.formData[name] !== 'undefined') {
        value = state.formData[name];
    }
    if (typeof state.formErrorMsg[name] !== 'undefined') {
        error = state.formErrorMsg[name];
    }
    return { error, value };
};

const mapDispatchToProps = (dispatch) => ({
    setValue: (name, value) => {
        dispatch({ type: 'SET_FORM_DATA', value, name });
    }
});

export default connect(mapStateToProps, mapDispatchToProps)(Input);