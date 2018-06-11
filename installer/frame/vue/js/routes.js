import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);
let routes = [];
let router = new Router({
    mode: 'history',
    routes
});

function isEmptyObject(obj) {
    for (var key in obj) {
        return false;
    }
    return true;
}

router.beforeEach((to, from, next) => {

    // ...
    /*if (to.path != "/login" && isEmptyObject(store.state.user)) {
        next({
            path : '/login',
            query: {redirect: to.fullPath}  // 将跳转的路由path作为参数，登录成功后跳转到该路由
        })
    } else if (to.path == "/login" && !isEmptyObject(store.state.user)) {
        next({
            path: '/customer',
        })
    } else {
        next();
    }*/
})

export default router