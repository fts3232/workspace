import React from 'react';
import Component from '../component';

class Panel extends Component {
    render() {
        const { children } = this.props;
        return (
            <div className={this.classNames('panel')}>
                {children}
            </div>
        );
    }
}

Panel.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错

};
Panel.defaultProps = {};// 设置默认属性

// 导出组件
export default Panel;