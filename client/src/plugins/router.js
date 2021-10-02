import { createRouter, createWebHistory } from 'vue-router';

export const router = createRouter({ 
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            redirect: "/welcome",
        },
        {
            name: "welcome",
            path: "/welcome",
            component: () => import("@/pages/welcome/index.vue")   
        },
        {
            name: "progress",
            path: "/progress",
            component: () => import("@/pages/progress/index.vue")   
        },
        {
            name: "explore",
            path: "/explore",
            component: () => import("@/pages/explore/index.vue")   
        },
    ],
})
