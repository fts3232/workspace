import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Input extends Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);
        this.state = {
            'value': props.value
        };
    }

    componentDidMount() {
        const { value, name } = this.props;
        const { setData } = this.context;
        setData(name, value);
    }

    onChange(e) {
        const { name, onChange, type } = this.props;
        const { setData } = this.context;
        let value ;
        if (type === 'file') {
            [value] = e.target.files;
        } else {
            ({ value } = e.target);
        }
        this.setState({ 'value': value }, () => {
            setData(name, value);
            if (onChange !== undefined) {
                onChange(value);
            }
        });
    }

    focus() {
        this.input.click();
    }

    render() {
        const { type, readonly, placeholder, name, id, style } = this.props;
        const { value } = this.state;
        return (
            <input
                ref={(c) => { this.input = c; }}
                id={id}
                style={style}
                className={this.classNames('form-control')}
                name={name}
                type={type}
                placeholder={placeholder}
                readOnly={readonly}
                value={value}
                onChange={this.onChange}
            />
        );
    }
}

Input.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    name       : PropTypes.string.isRequired,
    type       : PropTypes.string,
    placeholder: PropTypes.string,
    readonly   : PropTypes.bool,
    value      : PropTypes.string,
    style      : PropTypes.object
};
Input.defaultProps = {
    type       : 'text',
    value      : '',
    readonly   : false,
    style      : {},
    placeholder: ''
};// 设置默认属性

Input.contextTypes = {
    setData: PropTypes.func
};

// 导出组件
export default Input;