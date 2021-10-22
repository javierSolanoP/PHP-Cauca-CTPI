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
                  <h2 class="card-title">Especialidades Enfermeras</h2>
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
                <router-link class="btn btn-info agregar" to="/asigEnfermeras">Agregar</router-link>
            </template>
          </h4>

          <section class="row">
            <div class="col">
              <div class="card">
                <div class="card-body table-responsive-lg ">
                   <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                          
                        <th>Identificacion</th>
                        <th>Descripcion</th>
                        <th>Especialidad</th>
                        <!-- <th>Acciones</th> -->

                      </tr>
                    </thead>



                    <tbody>

                      <tr v-for="especialidad in  nursesSpecialities " 
                      :key="especialidad.identification">

                        <td>{{especialidad.identification}}</td>
                        
                        <td>{{especialidad.description}}</td>
                        <td>{{especialidad.speciality}}</td>
                        
                        
                        <!-- <td>
                         <button
                            class="btn btn-danger"
                            v-on:click="
                              Eliminar(especialidade.patient)
                            "
                          >
                            Eliminar
                          </button>
                        </td> -->

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

      nursesSpecialities:[],

    }
  },
  mounted(){
    this.EspecialidadEnfermeras();

  },

  methods:{

    EspecialidadEnfermeras(){
      axios
      .get("http://127.0.0.1:8000/api/nurse-specialities/v1")
      .then(datos =>{
        console.log(datos.data.nursesSpecialities)
        this.nursesSpecialities = datos.data.nursesSpecialities[0]
        
        
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
