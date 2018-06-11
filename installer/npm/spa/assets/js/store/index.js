import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export function createStore() {
    return new Vuex.Store({
        state    : {
            items: {}
        },
        actions   : {
            fetchItem({commit}, id) {
                // `store.dispatch()` 会返回 Promise，
                // 以便我们能够知道数据在何时更新
                commit('setItem', id)
            }
        },
        mutations: {
            setItem(state, id) {
                Vue.set(state.items, id)
            }
        }
        // 可以设置多个模块
        /*modules: {
            news
        }*/
    });
}