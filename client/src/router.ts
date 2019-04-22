import Vue from "vue";
import Router from "vue-router";
import Main from "./views/Main.vue";

Vue.use(Router);

export default new Router({
    mode: "history",
    base: process.env.BASE_URL,
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
            path: "/:ua?",
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
