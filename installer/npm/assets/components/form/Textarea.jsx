import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Textarea extends Component {
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
        const { value, rows, placeholder, id, error } = this.props;
        return (
            <div className={this.classNames('form-group', { 'has-error': error })}>
                <textarea rows={rows} className="form-control" defaultValue={value} placeholder={placeholder} onChange={this.onChange} id={id}/>
                {error ? (<p className="help-block">{error}</p>) : null}
            </div>
        );
    }
}

Textarea.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    rows       : PropTypes.number,
    name       : PropTypes.string.isRequired,
    placeholder: PropTypes.string,
    value      : PropTypes.string,
    error      : PropTypes.string
};
Textarea.defaultProps = {
    value      : '',
    rows       : 6,
    placeholder: '',
    error      : ''
};// 设置默认属性

Textarea.contextTypes = {
    setData: PropTypes.func
};

// 导出组件
export default Textarea;