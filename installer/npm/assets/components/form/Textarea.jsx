import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Textarea extends Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);
        this.state = {
            value: props.value
        };
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
        this.setState({ value: e.target.value });
    }

    render() {
        const { rows, placeholder, id } = this.props;
        const { value } = this.state;
        return (
            <textarea rows={rows} className="form-control" value={value} placeholder={placeholder} onChange={this.onChange} id={id}/>
        );
    }
}

Textarea.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    rows       : PropTypes.number,
    name       : PropTypes.string.isRequired,
    placeholder: PropTypes.string,
    value      : PropTypes.string
};
Textarea.defaultProps = {
    value      : '',
    rows       : 6,
    placeholder: ''
};// 设置默认属性

Textarea.contextTypes = {
    setData: PropTypes.func
};

// 导出组件
export default Textarea;