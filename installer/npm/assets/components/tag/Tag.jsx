import React from 'react';
import Component from '../component';

class Tag extends Component {
    render() {
        const { children } = this.props;
        return (
            <div className={this.classNames('tag')}>
                {children}
            </div>
        );
    }
}

Tag.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    
};
Tag.defaultProps = {};// 设置默认属性

// 导出组件
export default Tag;