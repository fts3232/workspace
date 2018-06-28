import React from 'react';
import App from './App.jsx';
import {BrowserRouter, StaticRouter} from "react-router-dom";
import { renderToString, renderToStaticMarkup } from 'react-dom/server';

/*import App from './App.vue';
//import ElementUI from 'element-ui';
import router from './router/index.js';
import store from './store/index.js';

//Vue.use(ElementUI);
const app = new Vue({
    store,
    router,
    render: (createElement) => {
        return createElement(App)
    },
})
app.$mount('#app')*/

function createApp(type, url, context) {
    if (type == 'server') {
        return renderToString(<App router={StaticRouter} location={url} context={context}/>)
    } else {
        ReactDOM.render(<App router={BrowserRouter} context={context}/>, document.getElementById('app'));
    }
}

export default createApp;
