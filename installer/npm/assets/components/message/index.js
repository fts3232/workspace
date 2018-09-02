import ReactDOM from 'react-dom';
import React from 'react';
import Message from './Message.jsx';

const notice = (type, content, duration) => {
    let messageDiv = document.querySelector('.message');
    if (!messageDiv) {
        messageDiv = document.createElement('div');
        messageDiv.className = 'message';
        document.body.appendChild(messageDiv);
    }

    const div = document.createElement('div');
    const willUnmount = () => {
        ReactDOM.unmountComponentAtNode(div);
        messageDiv.removeChild(div);
    };
    // react-router
    ReactDOM.render((
        <Message type={type} content={content} duration={duration} willUnmount={willUnmount}/>
    ), div);

    messageDiv.appendChild(div);
};

Message.success = (content, duration) => {
    notice('success', content, duration);
};

Message.error = (content, duration) => {
    notice('error', content, duration);
};

Message.info = (content, duration) => {
    notice('info', content, duration);
};

Message.warning = (content, duration) => {
    notice('warning', content, duration);
};

export default Message;