<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card type="chart">
          <template slot="header">
            <div class="row">
              <div class="col-sm-6">
                <template>
                  <h5 class="card-category">Servicios</h5>
                </template>

                <template>
                  <h2 class="card-title">Servicios</h2>
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
                <router-link class="btn btn-info agregar" to="/agregarServicio">Agregar</router-link>
            </template>
          </h4>

          <section class="row">
            <div class="col">
              <div class="card">
                <div class="card-body table-responsive-lg ">
                   <table class="table table-hover" >
                    <thead class="thead-dark"

                    >
                      <tr>
                        <th>Nombre</th>
                        <th>Cantidad de personal</th>
                        <th>Numero de Dias</th>
                        <th>Horas</th>
                        <th></th>
                    
                        
                      </tr>
                    </thead>

                    <tbody>

                      <tr v-for="servicios in services"
                    :key="servicios.service_name"
                    >
                        <td>{{servicios.service_name}}</td>
                        <td>{{servicios.personal_amount}}</td>
                        <td>{{servicios.number_of_days}}</td>
                        <td>{{servicios.hourlyintensity}}</td>
                        <td>
                          <button class="btn btn-info agregar"> editar</button>
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
  </div>
</template>

<script>
import axios from "axios"
import { Card } from "@/components/index";

export default {
  components: {
    Card,
  },

  data(){
    return{
      services:[],
      
    }
  },
  mounted(){
    this.MostrarServicios();

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
  }
}
</script>
<style  scoped>



th{
  color: aliceblue  !important;
}

</style>
