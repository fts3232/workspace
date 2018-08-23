import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Form extends Component {
    /* validate() {
        try {
            const { validateRule } = this.props;
            const rule = validateRule.split('|');
            const value = this.refs.input.value;
            for (let i = 0, len = rule.length; i < len; i++) {
                if (rule[i] === 'required' && value === '') {
                    throw new Error('不能为空');
                }
                if (rule[i] === 'num' && isNaN(value)) {
                    throw new Error('不是数字');
                }
                if (rule[i] === 'date') {
                    const reg = /^(\d+)-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
                    const r = value.match(reg);
                    if (r == null) {
                        throw new Error('不是日期');
                    }
                    r[2] -= 1;
                    const d = new Date(r[1], r[2], r[3], r[4], r[5], r[6]);
                    if (d.getFullYear() !== r[1]) {
                        throw new Error('不是日期');
                    }
                    if (d.getMonth() !== r[2]) {
                        throw new Error('不是日期');
                    }
                    if (d.getDate() !== r[3]) {
                        throw new Error('不是日期');
                    }
                    if (d.getHours() !== r[4]) {
                        throw new Error('不是日期');
                    }
                    if (d.getMinutes() !== r[5]) {
                        throw new Error('不是日期');
                    }
                    if (d.getSeconds() !== r[6]) {
                        throw new Error('不是日期');
                    }
                }
            }
        } catch (err) {
            this.setState({ 'error': true });
        }
    } */

    static onSubmit(e) {
        e.preventDefault();
        /* const { children } = this.prop;
        console.log(children);

        for (const i in this.refs) {
            console.log(this.refs[i]);
        } */
        const { onSubmit } = this.props;
        onSubmit();
        return false;
    }

    render() {
        const { children, action } = this.props;
        return (
            <form type={action} onSubmit={this.onSubmit}>
                {React.Children.map(children, (child, i) => React.cloneElement(child, {
                    ref: i
                }))}
            </form>
        );
    }
}

Form.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    action  : PropTypes.string,
    onSubmit: PropTypes.func,
    children: PropTypes.object
};
Form.defaultProps = {
    action  : 'post',
    children: {},
    onSubmit: () => {
    }
};// 设置默认属性

// 导出组件
export default Form;