import Home from "./pages/Home";
import Game from "./pages/Game";
const VueRouter = require('vue-router');

const routes = [
    { path: '/', component: Home },
    { path: '/game/:game', component: Game },
]

export const Router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
})
