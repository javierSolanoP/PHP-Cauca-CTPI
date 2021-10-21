<template>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <card type="chart">
          <template slot="header">
            <div class="row">
              <div class="col-sm-6">
                <template>
                  <h5 class="card-category">Servicio</h5>
                </template>

                <template>
                  <h2 class="card-title">Programar Servicio</h2>
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
                <div class="card-body">
                  <form class="row">
                    <div class="form-group col-md-4">
                      <label for="">Servicio</label>
                      <select  class="form-select"
                        aria-label="Default select example">
                        <option 
                        
                        v-for="servicios in services"
                           :key="servicios.service_name"
                           
                           

                       >{{servicios.service_name}}</option>
                      </select>
                    </div>



                    <div class="form-group col-md-4">
                      <label for="">Especialidad</label>
                      <select
                        class="form-select"
                        aria-label="Default select example"
                      >

                        <option value="2">fffff</option>
                      </select>
                    </div>


                    
                    <div class="form-group col-md-2 text-center ">
                      <router-link class="btn btn-info agregar my-3" to="/asignarServicio">Agregar</router-link>
                    </div>

                    <div class="form-group col-md-2 text-center ">
                      <div >
                      <div > Aforo</div>
                      <h1>2</h1>
                      </div>
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

    <div class="row">
      <div class="col-lg-12 col-md-12">
        <card class="card">
        
          <section class="row">
            <div class="col">
              <div class="card">
                
                <div class="card-body table-responsive-lg">
                    <h4 class="card-title my-4">Listado</h4>
                  <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Identificacion</th>
                        <th>Servicio</th>
                        <th>Especialidad</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="">
                        <td>Id</td>
                        <td>darly</td>
                        <td>1002965382</td>
                        <td>Urgencias</td>
                        <td>Paramedico</td>
                        <td>
                          <button class="btn btn-info agregar">Editar</button>
                          <button class="btn btn-danger">Eliminar</button>
                        </td>
                      </tr>

                      <tr class="">
                        <td>Id</td>
                        <td>darly</td>
                        <td>1002965382</td>
                        <td>Urgencias</td>
                        <td>Paramedico</td>
                        <td>
                          <button class="btn btn-info agregar">Editar</button>
                          <button class="btn btn-danger">Eliminar</button>
                        </td>
                      </tr>
                      
                    </tbody>
                    
                    
                  </table>
                </div>
              </div>
            </div>
          </section>
        </card>
      </div>
    </div>






  </section>
</template>


<script>
import {Card} from "@/components/index";
import axios from "axios"




export default {
  components:{
    Card,
  
  },

  data(){
    return{
      services:[],
      services_specialities:[],
    }
  },
  mounted(){
    this.MostrarServicios();
    this.MostrarProfecionesDeServicios();
  },

  methods:{
    MostrarServicios(){
      axios
      .get("http://127.0.0.1:8000/api/services/v1")
      .then(datos =>{
        console.log(datos)
        this.services = datos.data.services
      })
    },

    MostrarProfecionesDeServicios(){
      axios
      .get("http://127.0.0.1:8000/api/service-specialities/v1")
      .then(datos =>{
        console.log(datos)
        this.services_specialities =datos.data.services_specialities
      })
    }
    

  }
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
.agregar{
  margin: 0px 5px;
}

th{
  color: aliceblue  !important;
}
</style>


