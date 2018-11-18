import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import Icon from '../icon';
import Button from '../button';

class Modal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            leave: false
        };
        this.timeout = null;
        this.onClose = this.onClose.bind(this);
        this.onCancel = this.onCancel.bind(this);
    }

    componentDidMount() {
        const { duration, willUnmount } = this.props;
        if (duration !== 0) {
            this.timeout = setTimeout(() => {
                this.setState({ leave: true }, () => {
                    setTimeout(() => {
                        willUnmount();
                    }, 300);
                });
            }, duration);
        }
    }

    onClose() {
        const { willUnmount } = this.props;
        clearTimeout(this.timeout);
        this.setState({ leave: true }, () => {
            setTimeout(() => {
                willUnmount();
            }, 300);
        });
    }

    onCancel() {
        const { onCancel } = this.props;
        this.onClose();
        onCancel();
    }

    render() {
        const { type, title, content, okText, cancelText, onOk, showButton } = this.props;
        const { leave } = this.state;
        let icon;
        let okButtonType;
        switch (type) {
            case 'confirm':
                icon = 'question-circle';
                okButtonType = 'danger';
                break;
            case 'info':
                icon = 'info-circle';
                okButtonType = 'info';
                break;
            case 'success':
                icon = 'check-circle';
                okButtonType = 'info';
                break;
            case 'error':
                icon = 'close-circle';
                okButtonType = 'info';
                break;
            case 'warning':
                icon = 'warning-circle';
                okButtonType = 'info';
                break;
            default:
                okButtonType = 'info';
                break;
        }
        return (
            <div>
                <div role='button' className={this.classNames('modal-mask', { 'move-up-leave': leave, 'move-in-leave': !leave })} onClick={this.onClose}/>
                <div className={this.classNames('modal', { 'move-up-leave': leave, 'move-in-leave': !leave }, { [`modal-type-${ type }`]: type })}>
                    <div className="modal-content">
                        <Icon name="close" className="close" onClick={this.onClose}/>
                        <div className="modal-header">
                            {icon && (<Icon name={icon}/>)}<span className="modal-header-title">{title}</span>
                        </div>
                        <div className="modal-body">
                            {content}
                        </div>
                        {showButton ? (
                            <div className="modal-footer">
                                <Button type={okButtonType} onClick={onOk}>{okText}</Button>
                                {(type === 'confirm' || type === null) && (<Button onClick={this.onCancel}>{cancelText}</Button>)}
                            </div>)
                            : null}
                    </div>
                </div>
            </div>
        );
    }
}

Modal.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    type       : PropTypes.oneOf([null, 'warning', 'success', 'error', 'info', 'confirm']),
    content    : PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    onCancel   : PropTypes.func,
    onOk       : PropTypes.func,
    willUnmount: PropTypes.func.isRequired,
    title      : PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    cancelText : PropTypes.string,
    okText     : PropTypes.string,
    onConfirm  : PropTypes.func,
    duration   : PropTypes.number,
    showButton : PropTypes.bool
};
Modal.defaultProps = {
    type      : null,
    okText    : '确认',
    cancelText: '返回',
    onCancel  : ()=>{},
    onOk      : ()=>{},
    onConfirm : ()=>{},
    duration  : 0,
    showButton: true
};// 设置默认属性

// 导出组件
export default Modal;