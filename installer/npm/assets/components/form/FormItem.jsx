import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import { Row } from '../grid';
import style from './style/main.scss';

class FormItem extends Component {
    render() {
        const { children } = this.props;
        return (
            <Row className="form-item" style={style}>
                {children}
            </Row>
        );
    }
}

FormItem.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    children: PropTypes.any.isRequired
};
FormItem.defaultProps = {};// 设置默认属性


export default FormItem;