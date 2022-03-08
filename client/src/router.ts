import Vue from "vue";
import Router from "vue-router";
import Main from "./views/Main.vue";

Vue.use(Router);

export default new Router({
    mode: "history",
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
            path: "*",
            redirect: "/"
        }
    ]
});
