import Vue from "vue";
import VueSweetalert2 from 'vue-sweetalert2'
import VueRouter from "vue-router";
import VueGitHubButtons from "vue-github-buttons"
import App from "./App.vue";
import GlobalComponents from "./globalComponents";
import RTLPlugin from "./RTLPlugin";
import SideBar from "@/components/SidebarPlugin";
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import VueAxios  from 'vue-axios'
import  Axios from 'axios'




Vue.config.productionTip = false;


import routes from "./router";



const router = new VueRouter({
  routes,
  linkExactActiveClass: "active"
});

Vue.use(VueRouter);


Vue.use(VueGitHubButtons, { useCache: true });
Vue.use(GlobalComponents);
Vue.use(RTLPlugin);
Vue.use(SideBar);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueAxios , Axios)
Vue.use(VueSweetalert2)


import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-vue/dist/bootstrap-vue.min.css'
import 'sweetalert2/dist/sweetalert2.all'



new Vue({
  router,
  render: h => h(App)
}).$mount("#app");
