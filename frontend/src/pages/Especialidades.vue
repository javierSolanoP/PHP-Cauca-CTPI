<template>
  <div class="content">
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
                  <h2 class="card-title">Especialidades</h2>
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
                <router-link class="btn btn-info agregar" to="/agregarespecialidad">Agregar</router-link>
            </template>
          </h4>

          <section class="row">
            <div class="col">
              <div class="card">
                <div class="card-body table-responsive-lg ">
                   <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>Nombre de la Esppecialidad</th>
                        <th>Descripcion</th>
                        <th>Descripcion</th>
                    
                        
                      </tr>
                    </thead>

                    <tbody>

                      <tr v-for="especialidades in specialities " 
                      :key="especialidades.speciality_name">


                        <td>{{especialidades.speciality_name}}</td>
                        <td>{{especialidades.description}}</td>
                        <td>
                          <button class="btn btn-info agregar">
                            Editar
                          </button>
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
      specialities:[],
      
    }
  },
  mounted(){
    this.Especialidades();

  },

  methods:{
    //metodo para mostrar las especialidades existentes 

    Especialidades(){
      axios
      .get("http://127.0.0.1:8000/api/specialities/v1")
      .then(datos =>{
        console.log(datos)
        this.specialities = datos.data.specialities
      })
    },
  }

};
</script>
<style  scoped>



th{
  color: aliceblue  !important;
}

</style>
