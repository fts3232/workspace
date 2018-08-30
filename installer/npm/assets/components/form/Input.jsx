import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Input extends Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);


    }

    componentDidMount() {
        const { value, name } = this.props;
        const { setData } = this.context;
        setData(name, value);
    }

    onChange(e) {
        const { name } = this.props;
        const { setData } = this.context;
        setData(name, e.target.value);
    }

    render() {
        const { type, value, readonly, placeholder, error, name, id } = this.props;
        return (
            <div className={this.classNames('form-group', { 'has-error': error })}>
                <input
                    id={id}
                    className={this.classNames('form-control')}
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
    name       : PropTypes.string.isRequired,
    type       : PropTypes.string,
    placeholder: PropTypes.string,
    readonly   : PropTypes.bool,
    value      : PropTypes.string,
    error      : PropTypes.string
};
Input.defaultProps = {
    type       : 'text',
    value      : '',
    readonly   : false,
    placeholder: '',
    error      : ''
};// 设置默认属性

Input.contextTypes = {
    setData: PropTypes.func
};

// 导出组件
export default Input;