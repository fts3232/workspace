import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import Icon from '../icon';

class Modal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            leave: false
        };
        this.timeout = null;
        this.onClose = this.onClose.bind(this);
    }

    componentDidMount() {
        const { duration, willUnmount } = this.props;
        if (duration !== 0) {
            this.timeout = setTimeout(()=>{
                this.setState({ leave: true }, ()=>{
                    setTimeout(()=>{
                        willUnmount();
                    }, 300);
                });
            }, duration);
        }
    }

    onClose() {
        const { willUnmount } = this.props;
        clearTimeout(this.timeout);
        this.setState({ leave: true }, ()=>{
            setTimeout(()=>{
                willUnmount();
            }, 300);
        });
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
                        <Icon name="close" className="close" onClick={this.onClose}/>
                    </div>
                </div>
            </div>
        );
    }
}

Modal.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    type       : PropTypes.oneOf(['warning', 'success', 'error', 'info']).isRequired,
    content    : PropTypes.string.isRequired,
    onClose: PropTypes.func.isRequired
};
Modal.defaultProps = {

};// 设置默认属性

// 导出组件
export default Modal;