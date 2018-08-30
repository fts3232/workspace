import React from 'react';
import PropTypes from 'prop-types';
import { Row, Col } from '../grid';
import Component from '../component';

class FormItem extends Component {

    getId() {
        const { children } = this.props;
        const childrenArray = React.Children.toArray(children);
        return childrenArray[0].props.id;
    }

    render() {
        const { children, label, labelCol, wrapperCol, className } = this.props;
        return (
            <Row className="form-group">
                {label !== '' ? (
                    <Col {...labelCol} className="label-control">
                        <label htmlFor={this.getId()}>{label}</label>
                    </Col>
                ) : null}
                <Col {...wrapperCol} className={className}>
                    {children}
                </Col>
            </Row>
        );
    }
}

FormItem.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    label     : PropTypes.string,
    labelCol  : PropTypes.object,
    wrapperCol: PropTypes.object.isRequired
};
FormItem.defaultProps = {
    label   : '',
    labelCol: {}
};// 设置默认属性


export default FormItem;