import ReactDOM from 'react-dom';
import React from 'react';
import Modal from './Modal.jsx';

const notice = (type, content, duration) => {
    const div = document.createElement('div');
    div.className = 'modal';
    const onClose = () => {
        ReactDOM.unmountComponentAtNode(div);
        document.body.removeChild(div);
    };
    // react-router
    ReactDOM.render((
        <Modal type={type} content={content} onClose={willUnmount}/>
    ), div);

    document.body.appendChild(div);
};

Modal.delete = (title,content) => {
    notice('success', content, duration);
};

Modal.error = (content, duration) => {
    notice('error', content, duration);
};

Modal.info = (content, duration) => {
    notice('info', content, duration);
};

Modal.warning = (content, duration) => {
    notice('warning', content, duration);
};

export default Modal;