import  {createApp} from "vue";
import App from "./App.vue";
import {router} from "./router";
import './scss/style.scss'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'

const app = createApp(App);
app.use(router)

app.mount('#app');


// new Vue({
//   router,
//   render: (h) => h(App)
// }).$mount("#app");
//
