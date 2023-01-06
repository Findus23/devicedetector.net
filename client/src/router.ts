import {createRouter, createWebHistory} from "vue-router";
import Main from "./views/Main.vue";


export const router = createRouter
({
    history: createWebHistory(),
    // linkActiveClass: "active",
    routes: [
        {
            path: "/detected-devices",
            name: "detectedDevices",
            component: () => import(/* webpackChunkName: "detectedDevices" */ "./views/DetectedDevices.vue")
        },
        {
            path: "/contribute",
            name: "contribute",
            component: () => import(/* webpackChunkName: "about" */ "./views/Contribute.vue")
        },
        {
            path: "/ports",
            name: "ports",
            component: () => import(/* webpackChunkName: "ports" */ "./views/Ports.vue")
        },
        {
            path: "/:urlString?",
            name: "main",
            component: Main,
            props: true
        },
        {
            path: "/:pathMatch(.*)*",
            redirect: "/"
        }
    ]
});
