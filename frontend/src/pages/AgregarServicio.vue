<template>
  <section class="content">
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
                  <h2 class="card-title">Agregar Servicio</h2>
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
                  <form class=" col-4" >
                    <div class="form-group col-md-8">
                      <label for="">Nombre servicio</label>
                      <input type="text" class="form-control" v-model="form.service_name">
                    </div>
                    <div class="form-group col-md-8">
                      <label for="">Cantidad de Personal</label>
                      <input type="text" class="form-control" v-model="form.personal_amount">
                    </div>
                    <div class="form-group col-md-8">
                      <label for="">Numero de Dias</label>
                      <input type="text" class="form-control" v-model="form.number_of_days"> 
                    </div>
                    <div class="form-group col-md-8">
                      <label for="">Horas</label>
                      <input type="text" class="form-control" v-model="form.hourlyintensity">
                    </div>

                    <div class="form-group col-md-8">
                      <label for="">Horas</label>
                      <input type="file" class="form-control">
                    </div>

                     <div class="form-group col-md-8">
                      <button class="btn btn-info agregar" v-on:click="guardar()">Agregar</button>
                    </div>
                    
                  </form>
                    
                </div>
              </div>
            </div>
          </section>

          

      
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
            service_name:"",
            personal_amount:"",
            number_of_days:"",
            hourlyintensity:"",
        }
    }
  },

  methods:{
    guardar(){
      axios
      .post("http://127.0.0.1:8000/api/services/v1", this.form)
      .then(data => {
        console.log(data);

        if(data.status === 201){

        this.$swal({
          position:"top-end",
          title:"se guardó correctamente!!",
          icon:"success",
          timer:"2000",
          toast:"true",
        });
        this.$router.push('/servicios')
        

        }else{
          
        }
      });
    }
  },

  obtenerDocumento(event) {
    if (event.target.files[0].size <= 5000000) {
      //5mb tope
      let extDoc = event.target.files[0].name
        .toString()
        .substring(event.target.files[0].name.toString().lastIndexOf(".")); //extension del archivo
      if (extDoc == ".pdf") {
        this.docResolucon = event.target.files[0];
        Swal.fire({
          title: "Resolución Cargada!",
          text:"Archivo cargado exitosamente!",
          icon: "success",
          confirmButtonText: "Aceptar",
          confirmButtonColor: "#238276",
        });
        this.docValido = true;
      } else {
        this.docValido = false;
        this.docResolucon = null;
        Swal.fire(
          "Algo salió mal!",
          "El archivo cargado no es un PDF!",
          "error"
        );
      }
    } else {
      this.docValido = false;
      this.docResolucon = null;
      Swal.fire(
        "Algo salió mal!",
        "El archivo cargado pesa más de 5 MegaBytes!",
        "error"
      );
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
