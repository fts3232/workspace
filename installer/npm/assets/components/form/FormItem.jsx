import React from 'react';
import PropTypes from 'prop-types';
import { Row, Col } from '../grid';
import Component from '../component';

class FormItem extends Component {

    constructor(props) {
        super(props);
        this.state = {
            error: false
        };
    }

    componentDidMount() {
        if (this.context.addItem) {
            const name = this.getChildProps('name');
            if (typeof name !== 'undefined') {
                this.context.addItem(this.getChildProps('name'), this);
            }
        }
    }

    setError(error) {
        this.setState({
            'error': error
        });
    }

    getChild() {
        const { children } = this.props;
        const childrenArray = React.Children.toArray(children);
        return childrenArray[0];
    }

    getChildProps(key) {
        const child = this.getChild();
        return child.props[key];
    }

    render() {
        const { children, label, labelCol, wrapperCol, className } = this.props;
        const { error } = this.state;
        return (
            <Row className={this.classNames('form-group', { 'has-error': error })} gutter={15}>
                {label !== '' ? (
                    <Col {...labelCol} className="label-control">
                        <label htmlFor={this.getChildProps('id')}>{label}</label>
                    </Col>
                ) : null}
                <Col {...wrapperCol} className={className}>
                    {children}
                    {error ? (<p className="help-block">{error}</p>) : null}
                </Col>
            </Row>
        );
    }
}

FormItem.propTypes = { // 属性校验器，表示改属性必须是bool，否则报错
    label     : PropTypes.string,
    labelCol  : PropTypes.object,
    wrapperCol: PropTypes.object.isRequired
};
FormItem.defaultProps = {
    label   : '',
    labelCol: {}
};// 设置默认属性

FormItem.contextTypes = {
    addItem: PropTypes.func
};


export default FormItem;