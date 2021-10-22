<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card type="chart">
          <template slot="header">
            <div class="row">
              <div class="col-sm-6">
                <template>
                  <h5 class="card-category">Horarios</h5>
                </template>

                <template>
                  <h2 class="card-title">Horarios</h2>
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
                <router-link class="btn btn-info agregar" to="/agregarhorario">Agregar</router-link>
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
                        <th>Hora Inicio</th>
                        <th>Hora Final</th>
                        

                      </tr>
                    </thead>

                    <tbody>

                      <tr v-for="horarios in times"
                    :key="horarios.start_time"
                    >
                        <td >{{horarios.start_time}}</td>
                        <td>{{horarios.finish_time}}</td>
                        

                      

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
      times:[],
     
      
    }
  },

  mounted(){
    this.MostrarHorarios();

  },

  

  methods:{

    //metodo para mostrar los Pacientes existentes

    MostrarHorarios(){
      axios
      .get("http://127.0.0.1:8000/api/times/v1")
      .then(datos =>{
        console.log(datos)
        this.times = datos.data.times
      })
    },

    eliminar(){
      var enviar = {
        "pacienteId":this.form.pacienteId,
        
      };

      
      axios
      .delete("https://api.solodata.es/pacientes", {headers : enviar})
      .then(data=>{
        console.log(data)
        // this.$router.push('/dashboard')
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



