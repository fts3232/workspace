import Vue from 'vue';
import App from './Components/App.vue';
import ElementUI from 'element-ui';
import router from './routes.js';
import store from './store/index.js';

Vue.use(ElementUI);
const vue = new Vue({
    store,
    router,
    render: (createElement) => {
        return createElement(App)
    },
}).$mount('#app');