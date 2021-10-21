<template>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <card type="chart">
          <template slot="header">
            <div class="row">
              <div class="col-sm-6">
                
                <template>
                  <h5 class="card-category">Especialidades</h5>
                </template>

                <template>
                  <h2 class="card-title">Agregar Especialidad</h2>
                </template>
              </div>
            </div>
          </template>
        </card>
      </div>
    </div>

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
                <div class="card-body row">
                    
                <div class="col-4"></div>
                  <form class=" col-4">
                    <div class="form-group col-md-8">
                      <label for="">Nombre De La Especialidad</label>
                      <input type="text" class="form-control" v-model="form.speciality_name">
                    </div>
                    <div class="form-group col-md-8">
                      <label for="">Descripcion</label>
                      <input type="text" class="form-control" v-model="form.description">
                    </div>
                    
                    
                     <div class="form-group col-md-8">
                      <button class="btn btn-info agregar" v-on:click="guardar()">Agregar</button>
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

    

  </section>
</template>



<script>
import axios from   "axios"
import { Card } from "@/components/index";
import Servicio from '../components/Servicio.vue';

export default {
  components: {
    Card,
    Servicio
    
  },

  data(){
    return{
        form:{
            speciality_name:"",
            description:"",
            
        }
    }
  },

  methods:{
    guardar(){
      axios
      .post("http://127.0.0.1:8000/api/specialities/v1", this.form)

      .then(data => {

        this.$swal({
          position:"top-end",
          title:"se guardó correctamente!!",
          icon:"success",
          timer:"2000",
          toast:"true",
        });
        this.$router.push('/especialidades')
        console.log(data);
        
      });
      
      
      
    }
  }
}
</script>
<style>
input {
  width: 80px;
}

.agregar{

background:#11AAB8 !important;
}

.agregar:hover{
  background-color: #11AAB8 !important;
}

th{
  color: aliceblue  !important;
}
</style>
