<template>
  <nav class="navbar navbar-expand-lg navbar-absolute"
       :class="{showMenu, 'navbar-transparent': !showMenu}">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle d-inline" :class="{toggled: $sidebar.showSidebar}">
          <button type="button"
                  class="navbar-toggler"
                  @click="toggleSidebar">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" href="javascript:void(0)"> {{ $route.name }}</a>
      </div>

      <button class="navbar-toggler" type="button"
              @click="toggleMenu"
              data-toggle="collapse"
              data-target="#navigation"
              aria-expanded="false"
              aria-label="Toggle navigation">

      </button>



      <div class="collapse navbar-collapse show text-left" v-show="showMenu">
        <ul class="navbar-nav" :class="$rtl.isRTL ? 'mr-auto' : 'ml-auto'">
          <li class="search-bar input-group"  @click="searchModalVisible = true">
            <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split"></i>
              <span class="d-lg-none d-md-block">Search</span>
            </button>
          </li>
          <modal :show.sync="searchModalVisible"
                 class="modal-search"
                 id="searchModal"
                 :centered="false"
                 :show-close="true">
            <input slot="header" v-model="searchQuery" type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
          </modal>
        
          <drop-down>
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                    <img src="@/assets/img/anime3.png" alt="Profile Photo">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    Log out
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                  <li class="nav-link"><router-link href="javascript:void(0)" class="nav-item dropdown-item" to="/user">Profile</router-link></li>
                  <li class="dropdown-divider"></li>
                  <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Log out</a></li>
                </ul>
              </drop-down>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>

import DropDown from "@/components/Dropdown.vue";
import Modal from "@/components/Modal.vue";
import {
  SidebarPlugin
} from "@/components/index";

  export default{
    components:{
      DropDown,
      Modal,
      SidebarPlugin
    },
    data() {
      return {
        searchModalVisible: false,
        searchQuery: '',
        showMenu: false
      };
    },
    methods:{
      toggleSidebar(){
        this.$sidebar.displaySidebar(!this.$sidebar.showSidebar);
      },
      toggleMenu(){
        this.showMenu  = !this.showMenu;
      }
    },
    computed:{
      isRTL() {
        return this.$rtl.isRTL;
      }
    }
  }
</script>
<style>
</style>
