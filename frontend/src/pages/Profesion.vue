<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card type="chart">
          <template slot="header">
            <div class="row">
              <div class="col-sm-6">
                <template>
                  <h5 class="card-category">Profesiones</h5>
                </template>

                <template>
                  <h2 class="card-title">Agregar Profesion</h2>
                </template>
              </div>
            </div>
          </template>
        </card>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 col-md-12">
        <card class="card">

          <h4 slot="header" class="card-title mb-4">
            <template> 
            </template>
          </h4>

          <section class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                 <form class="row">
                   <div class="form-group col-md-4">
                     <label for="">Identificacion</label>
                     <input type="text" class="form-control" placeholder="Identificaccion">
                   </div>
                   <div class="form-group col-md-4">
                     <label for="">Especialidad</label>
                     <select class="form-select" aria-label="Default select example">
                        <option value="1">---seleccione---</option>
                        <option value="2">pediatra</option>
                      </select>
                   </div>
                 </form>
                </div>
              </div>
            </div>
          </section>
        </card>
      </div>
    </div>
  </div>
</template>

<script>
import {
  Card
} from "@/components/index";

 export default {
   components: {
     Card
   }
 }
</script>
<style>
</style>
