import React from 'react';
import ReactDOM from 'react-dom';
import App from './site/App';

// 加载style
require.context('./components', true, /^\.\/[^_][\w-]+\/style\/main\.scss?$/);
require.context('./site/style', true, /^\.\/[\w-]+\.scss?$/);
require.context('./site/views', true, /^\.\/[^_][\w-]+\/style\/main\.scss?$/);

// react-router
ReactDOM.render((
    <App/>
), document.getElementsByTagName('section')[0]);