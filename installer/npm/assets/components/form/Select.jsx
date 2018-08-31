import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Component from '../component';

class Select extends Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);
    }

    componentDidMount() {
        const { setData } = this.props;
        const value = this.getDefaultValue();
        setData(value);
    }

    componentDidUpdate() {
        const { setData } = this.props;
        const value = this.getDefaultValue();
        setData(value);
    }

    onChange(e) {
        const { setData } = this.props;
        setData(e.target.value);
    }

    getDefaultValue() {
        let { data, value } = this.props;
        data = Object.entries(data);
        if (value === '') {
            value = data.length > 0 ? data[0][0] : '';
        }
        return value;
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

const mapState = (state, ownProps) => ({
    value: typeof state.data[ownProps.name] !== 'undefined' ? state.data[ownProps.name] : ownProps.value,
    error: typeof state.error[ownProps.name] !== 'undefined' ? state.error[ownProps.name] : ''
});
const mapDispatch = (dispatch, ownProps) => ({
    setData: (value) => {
        dispatch({ 'type': 'SET_DATA', value, name: ownProps.name });
    }
});

// 导出组件
export default connect(mapState, mapDispatch)(Select);