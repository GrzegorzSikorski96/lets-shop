import Vue from "vue"
import Router from "vue-router"
import Login from "./components/Auth/Login";
import HomePage from "./components/HomePage/HomePage";
import Register from "./components/Auth/Register";
import Group from "./components/Group/Group";

Vue.use(Router);

export default new Router({
    mode: "history",

    routes: [
        {
            path: '/',
            name: 'HomePage',
            component: HomePage,
        },
        {
            path: '/login',
            name: 'Login',
            component: Login,
            meta: {
                forVisitors: true,
            }
        },
        {
            path: '/register',
            name: 'Register',
            component: Register,
            meta: {
                forVisitors: true,
            }
        },
        {
            path: '/group/:id',
            name: 'Group',
            component: Group,
            props: true
        }
    ]
})