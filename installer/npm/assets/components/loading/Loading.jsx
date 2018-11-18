import React from 'react';
import Component from '../component';
import Icon from '../icon';

class Loading extends Component {
    render() {
        return (
            <div className="loading">
                <div className="spinner">
                    <Icon name="spinner"/>
                    <p>Loading...</p>
                </div>
            </div>
        );
    }
}

Loading.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错

};
Loading.defaultProps = {

};// 设置默认属性

// 导出组件
export default Loading;