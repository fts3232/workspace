import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
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
        const { label, type, value, readonly, placeholder, status } = this.props;
        const { error, errorMsg } = this.state;
        return (
            <div className={this.classNames(style['form-group'], { 'has-error': error })}>
                <label className={this.classNames(style['label-control'], 'col-2')}>{label}</label>
                <div className='col-10'>
                    <input
                        className={this.classNames(style['form-control'], style[status])}
                        type={type}
                        placeholder={placeholder}
                        readOnly={readonly}
                        value={value}
                        ref={(input) => {
                            this.input = input;
                        }}
                    />
                    {error ? (<p className="help-block">{errorMsg}</p>) : null}
                </div>
            </div>
        );
    }
}

Input.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    label      : PropTypes.string.isRequired,
    type       : PropTypes.string,
    placeholder: PropTypes.string,
    readonly   : PropTypes.bool,
    value      : PropTypes.string,
    status     : PropTypes.string
};
Input.defaultProps = {
    type       : 'text',
    value      : '',
    readonly   : false,
    placeholder: '',
    status     : 'default'
};// 设置默认属性

// 导出组件
const mapStateToProps = (state) => ({
    status: state.status
});
const Inputs = connect(mapStateToProps)(Input);
export default Inputs;