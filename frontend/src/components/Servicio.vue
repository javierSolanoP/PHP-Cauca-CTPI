<template>
  <section class="content">

    <div class="row">
      <div class="col-lg-12 col-md-12">
        <card class="card">
          <div class="card-header">
          <h4 slot="header" class="card-title mb-4">
            <template> </template>
          </h4>
          </div>
          

          <section class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <form class="row">
                    <div class="form-group col-md-6">
                      <label for="">Servicio</label>
                      <select  class="form-select"
                        aria-label="Default select example"
                      >
                        <option value="1">---seleccione---</option>
                        <option value="2">Urgencias</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Especialidad</label>
                      <select
                        class="form-select"
                        aria-label="Default select example"
                      >
                        <option value="1">---seleccione---</option>
                        <option value="2">pediatra</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </section>

          

          <!-- <button class="btn btn-info agregar">Agregar</button> -->
        </card>
      </div>
    </div>
  </section>
</template>


<script>
import {
  Card
} from "@/components/index";




export default {
    name:"Servicio",

  components:{
    Card
  },
}
</script>



<style  scoped>

.circulo{
  margin: 10px 50px ;
  height: 80px; 
  width: 85px;
 border-radius: 180px;
 box-shadow: 2px 2px 10px 2px gray;
}

/* .boton{
  background-color: #11AAB8 !important;

} */
</style>


