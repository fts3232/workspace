import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import Component from '../component';

class Textarea extends Component {
    constructor(props) {
        super(props);
        this.onChange = this.onChange.bind(this);
    }

    componentDidMount() {
        const { value, setData } = this.props;
        setData(value);
    }

    onChange(e) {
        const { setData } = this.props;
        setData(e.target.value);
    }

    render() {
        const { value, rows, placeholder, id, error } = this.props;
        return (
            <div className={this.classNames('form-group', { 'has-error': error })}>
                <textarea rows={rows} className="form-control" value={value} placeholder={placeholder} onChange={this.onChange} id={id}/>
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
export default connect(mapState, mapDispatch)(Textarea);