import Vue from 'vue';
import App from './App.vue';
//import ElementUI from 'element-ui';
import { createRouter } from './router/index.js';
import { createStore } from './store/index.js';
import { sync } from 'vuex-router-sync'

//Vue.use(ElementUI);

export function createApp (context) {
    const router = createRouter()
    const store = createStore()
    sync(store, router)
    const app = new Vue({
        store,
        router,
        render: (createElement) => {
            return createElement(App)
        },
    })
    return {app,router,store};
}