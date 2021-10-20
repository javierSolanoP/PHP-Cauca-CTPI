

import DropDown from "./components/Dropdown.vue";


import '@/assets/scss/white-dashboard.scss';
import '@/assets/css/nucleo-icons.css';
import "@/assets/demo/demo.css";

/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */

const GlobalComponents = {
  install(Vue) {
 
 
    Vue.component("drop-down", DropDown);

  }
};

export default GlobalComponents;
