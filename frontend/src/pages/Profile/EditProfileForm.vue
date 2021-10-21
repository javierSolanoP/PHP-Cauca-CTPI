<template>
  <card>
    <template slot="header">
      <h5 class="title">Perfil</h5>
    </template>
    <div class="row">
      <div class="col-md-5 pr-md-1 text-left">
        <label> Nombre</label>
        <input class="form-control mb-3">
      </div>
      <div class="col-md-3 px-md-1 text-left">
        <label>Apellido</label>
        <input class="form-control mb-3">
      </div>
      <div class="col-md-4 pl-md-1 text-left">
        <label>Identificacion</label>
        <input class="form-control mb-3">
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 pr-md-1 text-left">
        <label>Profesion</label>
        <input label="City" class="form-control mb-3">
      </div>
      <div class="col-md-6 pl-md-1 text-left">
        <label>Telefono</label>
        <input class="form-control mb-3">
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 text-left">
        <label>Gmail</label>
        <input class="form-control mb-3">
      </div>
    </div>


    <div class="row">
      <div class="col-md-4 pr-md-1 text-left">
        <label>Servicios</label>
        <input class="form-control">
      </div>
    </div>
    
    <template slot="footer">
          <button class="btn btn-info agregar">Actualizar</button>
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
