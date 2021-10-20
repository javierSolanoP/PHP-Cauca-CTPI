<template>
  <card>
    <template slot="header">
      <h5 class="title">Perfil</h5>
    </template>
    <div class="row">
      <div class="col-md-5 pr-md-1 text-left">
        <input label="City"
        class="form-control mb-3"
                  
                  placeholder="City">
      </div>
      <div class="col-md-3 px-md-1 text-left">
        <input label="City"
        class="form-control mb-3"
                  
                  placeholder="City">
      </div>
      <div class="col-md-4 pl-md-1 text-left">
        <input label="City"
        class="form-control mb-3"
                  
                  placeholder="City">
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 pr-md-1 text-left">
        <input label="City"
        class="form-control mb-3"
                  
                  placeholder="City">
      </div>
      <div class="col-md-6 pl-md-1 text-left">
        <input label="City"
        class="form-control mb-3"
                 
                  placeholder="City">
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 text-left">
        <input label="City"
        class="form-control mb-3"
                  
                  placeholder="City">
      </div>
    </div>


    <div class="row">
      <div class="col-md-4 pr-md-1 text-left">
        <input label="City"
        class="form-control"
                  
                  placeholder="City">
      </div>
    </div>
    
    <template slot="footer">
      <button  class="btn btn-info" type="success" fill>Guardar</button>
    </template>
  </card>
</template>
<script>

import {
  Card
} from "@/components/index";

export default {
  components:{
  Card
  },
}

</script>
<style>

</style>
