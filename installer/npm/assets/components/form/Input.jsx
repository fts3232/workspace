import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

class Input extends Component {
    constructor(props) {
        super(props);
        this.state = {
            'error'   : false,
            'errorMsg': ''
        };
    }

    render() {
        const { label, type } = this.props;
        const { error, errorMsg } = this.state;
        return (
            <div className={this.classNames(style['form-group'], { 'has-error': error })}>
                <label className={this.classNames(style['label-control'], 'col-2')}>{label}</label>
                <input
                    type={type}
                    className={this.classNames(style['form-control'], 'col-10')}
                    ref={(input) => {
                        this.input = input;
                    }}
                />
                {error ? (<p className="help-block">{errorMsg}</p>) : null}
            </div>
        );
    }
}

Input.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    label: PropTypes.string.isRequired,
    type : PropTypes.string
    // validateRule: PropTypes.string
};
Input.defaultProps = {
    type: 'text'
    // validateRule: ''
};// 设置默认属性

// 导出组件
export default Input;