import ReactDOM from 'react-dom';
import React from 'react';
import Modal from './Modal.jsx';

const notice = (props) => {
    const div = document.createElement('div');
    const willUnmount = () => {
        ReactDOM.unmountComponentAtNode(div);
        document.body.removeChild(div);
    };
    let modal = null;
    // react-router
    ReactDOM.render((
        <Modal {...props} willUnmount={willUnmount} ref={(component)=>{ modal = component; }}/>
    ), div);

    document.body.appendChild(div);
    return modal;
};

Modal.show = (props) => notice(props);

Modal.confirm = (props) => {
    props = Object.assign({ 'type': 'confirm', 'okText': '是', 'cancelText': '否' }, props);
    return notice(props);
};

Modal.success = (props) => {
    props = Object.assign( { 'type': 'success', 'okText': '知道了' }, props);
    return notice( title, content, duration, 'success');
};

Modal.error = (props) => {
    props = Object.assign( { 'type': 'error', 'okText': '知道了' }, props);
    return notice(title, content, duration, 'error');
};

Modal.info = (props) => {
    props = Object.assing( { 'type': 'info', 'okText': '知道了' }, props);
    return notice(title, content, duration, 'info');
};

Modal.warning = (props) => {
    props = Object.assign({ 'type': 'warning', 'okText': '知道了' }, props);
    return notice(title, content, duration, 'warning');
};

export default Modal;