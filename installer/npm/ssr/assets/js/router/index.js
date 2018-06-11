import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);


/*function isEmptyObject(obj) {
    for (var key in obj) {
        return false;
    }
    return true;
}

router.beforeEach((to, from, next) => {

    // ...
    if (to.path != "/login" && isEmptyObject(store.state.user)) {
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
    }
})*/

const Foo = () => import('../components/Foo.vue')
const Bar = () => import('../components/Bar.vue')



export function createRouter () {
    let routes = [
        {path: '/Foo', component: Foo},
        {path: '/Bar', component: Bar},
    ]
    return new Router({
        mode: 'history',
        routes
    });
}

/*
const Home = () => import('./views/Home/List.vue');
const Customer = () => import('./views/Customer/List.vue');
const Account = () => import('./views/Account/List.vue');
const Withdrawal = () => import('./views/Withdrawal/List.vue');
const Injection = () => import('./views/Injection/List.vue');
const InjectionSetting = () => import('./views/Injection/Setting.vue');
const User = () => import('./views/User/List.vue');
const Login = ()=>import('./views/Login/Login.vue');
const CusLog = ()=>import('./views/Log/Customer.vue');

const Nav = ()=>import('./views/Layout/Nav.vue');
const Header = ()=>import('./views/Layout/Header.vue');

let routes = [
    { path: '', redirect: '/customer' },
    { path: '/login', components: {
            default:Login,
            nav:null,
            header:null
        } },
    { path: '/home', components: {
            default:Home,
            nav:Nav,
            header:Header
        } },
    { path: '/log/customer', components: {
            default:CusLog,
            nav:Nav,
            header:Header
        } },
    { path: '/customer/:id?', components: {
            default:Customer,
            nav:Nav,
            header:Header
        } },
    { path: '/account/:id?', components: {
            default:Account,
            nav:Nav,
            header:Header
        } },
    { path: '/withdrawal', components: {
            default:Withdrawal,
            nav:Nav,
            header:Header
        } },
    { path: '/injection/list', components: {
            default:Injection,
            nav:Nav,
            header:Header
        } },
    { path: '/injection/setting', components: {
            default:InjectionSetting,
            nav:Nav,
            header:Header
        } },
    { path: '/user', components: {
            default:User,
            nav:Nav,
            header:Header
        } }
];

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
    if(to.path!="/login" && isEmptyObject(store.state.user)){
        next({
            path: '/login',
            query: {redirect: to.fullPath}  // 将跳转的路由path作为参数，登录成功后跳转到该路由
        })
    }else if(to.path=="/login" && !isEmptyObject(store.state.user)){
        next({
            path: '/customer',
        })
    }else{
        next();
    }
})

export default router*/
