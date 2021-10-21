<template>
  <card type="user">
    <div class="author">

      <a href="#">
        <img class="avatar" src="../../assets/img/anime6.png">
        <h5 class="title">{{ user.fullName }}</h5>
      </a>



    </div>
    
  </card>
</template>
<script>

import {
  Card
} from "@/components/index";



export default {
  components: {
    Card,

  },
  
  props: {
    user: {
      type: Object,
      default: () => {
        return {};
      }
    }
  }
}
</script>
<style>
</style>
