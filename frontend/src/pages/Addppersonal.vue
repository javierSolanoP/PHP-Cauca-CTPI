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

   <Servicio/>

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
import Servicio from '../components/Servicio.vue';




export default {
  components:{
    Card,
    Servicio
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
.agregar{
  margin: 0px 5px;
}

th{
  color: aliceblue  !important;
}
</style>


