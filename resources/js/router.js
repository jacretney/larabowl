import Home from "./pages/Home";
import About from "./pages/About";
const VueRouter = require('vue-router');

const routes = [
    { path: '/', component: Home },
    { path: '/about', component: About },
]

export const Router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
})
