import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import Icon from '../icon';

class Message extends Component {
    constructor(props) {
        super(props);
        this.state = {
            leave: false
        };
    }

    componentDidMount() {
        const { duration, willUnmount } = this.props;
        if (duration !== 0) {
            setTimeout(()=>{
                this.setState({ leave: true }, ()=>{
                    setTimeout(()=>{
                        willUnmount();
                    }, 300);
                });
            }, duration);
        }
    }

    render() {
        const { type, content } = this.props;
        const { leave } = this.state;
        let iconName;
        switch (type) {
            case 'success':
                iconName = 'check-circle-fill';
                break;
            case 'info':
                iconName = 'info-circle-fill';
                break;
            case 'warning':
                iconName = 'warning-circle-fill';
                break;
            case 'error':
                iconName = 'close-circle-fill';
                break;
            default:
                break;
        }
        return (
            <div className={this.classNames('message-notice', { 'move-up-leave': leave, 'move-in-leave': !leave })}>
                <div className="message-notice-content">
                    <div className={this.classNames('message-custom-content', `message-${ type }`)}>
                        <Icon name={iconName}/><span>{content}</span>
                    </div>
                </div>
            </div>
        );
    }
}

Message.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    type       : PropTypes.oneOf(['warning', 'success', 'error', 'info']).isRequired,
    content    : PropTypes.string.isRequired,
    willUnmount: PropTypes.func.isRequired,
    duration   : PropTypes.number
};
Message.defaultProps = {
    duration: 0
};// 设置默认属性

// 导出组件
export default Message;