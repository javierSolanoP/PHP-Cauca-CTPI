import Vue from 'vue'
import App from './App.vue'
import router from './router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueAxios from 'vue-axios'
import Axios from 'axios'


// import VueSweetalert2 from 'vue-sweetalert2';



Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueAxios, Axios)
// Vue.use(VueSweetalert2)

// Vue.use(VueSweetalert2);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'sweetalert2/dist/sweetalert2.all'


// import 'sweetalert2/dist/sweetalert2.all'

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')