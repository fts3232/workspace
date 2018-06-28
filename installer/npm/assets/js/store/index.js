import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

let store = new Vuex.Store({
    state    : {
        count: 0
    },
    actions  : {
        setItem({commit}) {
            // `store.dispatch()` 会返回 Promise，
            // 以便我们能够知道数据在何时更新
            commit('setItem')
        }
    },
    mutations: {
        setItem(state) {
            state.count++
        }
    }
    // 可以设置多个模块
    /*modules: {
        news
    }*/
});

export default store;