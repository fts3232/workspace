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

    render() {
        const { type, title, content, okText, cancelText } = this.props;
        const { leave } = this.state;
        let icon;
        switch (type) {
            case 'delete':
                icon = 'question-circle';
            case 'confirm':
                icon = 'question-circle';
        }
        return (
            <div>
                <div className={this.classNames('modal-mask', { 'move-up-leave': leave, 'move-in-leave': !leave })} onClick={this.onClose}/>
                <div className="modal-wrap">
                    <div className={this.classNames('modal', { 'move-up-leave': leave, 'move-in-leave': !leave })}>
                        <div className="modal-content">
                            <Icon name="close" className="close" onClick={this.onClose}/>
                            <div className="modal-header">
                                <Icon name={icon}/>{title}
                            </div>
                            <div className="modal-body">
                                {content}
                            </div>
                            <div className="modal-footer">
                                <Button type="info">{okText}</Button>
                                <Button onClick={this.onClose}>{cancelText}</Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

Modal.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    type       : PropTypes.oneOf(['warning', 'success', 'error', 'info', 'success', 'confirm']).isRequired,
    content    : PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    onClose    : PropTypes.func,
    willUnmount: PropTypes.func.isRequired,
    header     : PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    cancelText : PropTypes.string,
    okText     : PropTypes.string,
    onConfirm  : PropTypes.func,
    onCancel   : PropTypes.func,
    duration   : PropTypes.number
};
Modal.defaultProps = {
    okText    : '确认',
    cancelText: '取消',
    duration  : 0
};// 设置默认属性

// 导出组件
export default Modal;