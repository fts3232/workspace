import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Select extends Component {
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
        const { data, value, error, name, id } = this.props;
        return (
            <div className={this.classNames('form-group', { 'has-error': error })}>
                <select className="form-control" onChange={this.onChange} name={name} value={value} id={id}>
                    {Object.entries(data).map((v, i) => (<option value={v[0]} key={i}>{v[1]}</option>))}
                </select>
                {error ? (<p className="help-block">{error}</p>) : null}
            </div>
        );
    }
}

Select.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    data : PropTypes.object.isRequired,
    name : PropTypes.string.isRequired,
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
    error: PropTypes.string
};
Select.defaultProps = {
    value: '',
    error: ''
};// 设置默认属性

Select.contextTypes = {
    setData: PropTypes.func
};

// 导出组件
export default Select;