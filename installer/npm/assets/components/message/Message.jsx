import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import Icon from '../icon';

class Message extends Component {

    render() {
        const { type, content } = this.props;
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
        }
        return (
            <div className={this.classNames('message')}>
                <span>
                    <div className="message-notice">
                        <div className="message-notice-content">
                            <div className={this.classNames('message-custom-content', `message-${ type }`)}>
                                <Icon name={iconName}/><span>{content}</span>
                            </div>
                        </div>
                    </div>
                </span>
            </div>
        );
    }
}

Message.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    type   : PropTypes.oneOf(['warning', 'success', 'error', 'info']).isRequired,
    content: PropTypes.string.isRequired
};
Message.defaultProps = {};// 设置默认属性

// 导出组件
export default Message;