import React from 'react';
import Component from '../../../components/component';

class Footer extends Component {
    render() {
        return (
            <div className='footer'/>
        );
    }
}

Footer.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错

};
Footer.defaultProps = {};// 设置默认属性

// 导出组件
export default Footer;