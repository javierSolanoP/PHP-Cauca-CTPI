<template>
  <div class="sidebar" style="background:#11AAB8;">
      <div class="sidebar-wrapper text-left">
        <div class="logo">

          <img   src="@/assets/logos.svg" >
        </div>
        <ul class="nav">
          <slot>
            <sidebar-link>
            </sidebar-link>
          </slot>
        </ul>
      </div>
  </div>
</template>
<script>
import SidebarLink from "./SidebarLink.vue";

export default {
  
  name: "side-bar",
  components: {
    SidebarLink
  },
  props: {
   
    
    sidebarLinks:{
      type: Array,
      default: () => []
    }
  },
  data(){
    return{
      activeLinkIndex: 0
    }
  },
  computed:{
    isRTL() {
      return this.$rtl.isRTL;
    }
  },
  methods:{
    findActiveLink(){
      this.links.forEach((link, index) => {
        if(link.isActive()){
          this.activeLinkIndex = index;
        }
      });
    }
  }
}
</script>
<style>
.sidebar{
  background-color: #11AAB8 !important;
}

img{
  margin: 0px 62px;
  width: 80px;
  height:75px;
  border-radius:40px ;
}
</style>
