<template>
  <component
      :is="tag"
      class="dropdown nav-item"
      :class="{show: isOpen}"
      @click="toggleDropDown"
      >
      <slot></slot>
  </component>
</template>
<script>

// import ClickOutside from 'vue-click-outside';

  export default {
    name: "drop-down",
    props:{
      tag:{
        type: String,
        default: "li"
      }
    },
    data(){
      return{
        isOpen: false
      };
    },
    methods: {
      toggleDropDown(){
        this.isOpen = !this.isOpen;
      },
      closeDropDown(){
        this.isOpen = false;
      }
    }
  }
</script>

<style scoped >

.dropdown-item.active, .dropdown-item:active {
    color: #11AAB8 !important;
    text-decoration: none;
    background-color: #e1e5eb;
}

</style>
