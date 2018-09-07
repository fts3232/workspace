import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import Icon from '../icon';

class Loading extends Component {
    constructor(props) {
        super(props);
        this.state = {
            leave: false
        };
        this.timeout = null;
    }

    destory() {
        const { willUnmount } = this.props;
        clearTimeout(this.timeout);
        this.setState({ leave: true }, ()=>{
            setTimeout(()=>{
                willUnmount();
            }, 300);
        });
    }

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