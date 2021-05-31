import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home.vue';
import PlantCreate from "./pages/PlantCreate";


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/new-plant',
            name: 'plant_create',
            component: PlantCreate
        }
    ]
});

export default router;
