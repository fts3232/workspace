import ReactDOM from 'react-dom';
import React from 'react';
import Modal from './Modal.jsx';

const notice = (type, title, content, duration) => {
    const div = document.createElement('div');
    const willUnmount = () => {
        ReactDOM.unmountComponentAtNode(div);
        document.body.removeChild(div);
    };
    // react-router
    ReactDOM.render((
        <Modal type={type} title={title} content={content} willUnmount={willUnmount}/>
    ), div);

    document.body.appendChild(div);
};

Modal.delete = (title, content, duration) => {
    notice('delete', title, content, duration);
};

Modal.success = (title, content, duration) => {
    notice('success', title, content, duration);
};

Modal.error = (title, content, duration) => {
    notice('error', title, content, duration);
};

Modal.info = (title, content, duration) => {
    notice('info', title, content, duration);
};

Modal.warning = (title, content, duration) => {
    notice('warning', title, content, duration);
};

export default Modal;