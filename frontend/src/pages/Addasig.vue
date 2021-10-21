<template>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <card type="chart">
          <template slot="header">
            <div class="row">
              <div class="col-sm-6">
                <template>
                  <h5 class="card-category">Asignacion</h5>
                </template>

                <template>
                  <h2 class="card-title">Agregar Asignacion</h2>
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

            <section class="row">
              <div class="col">
                <div class=" cardcol-sm-6 form">
                  <div class=" form-peice">
                    <form>
                      <div class="form-group">
                        <label for="name">Nombre Paciente</label>
                         <input type="text"/>
                        <select  class="form-select"
                        aria-label="Default select example"
                         v-model="form.patient_name" >
                        <option 
                        v-for="paciente in patients"
                           :key="paciente.patient_name"

                       >{{paciente.patient_name}}</option>
                      </select>

                      </div>

                      <div class="form-group">
                        <label >Especialidad</label>
                        <input type="text"/>

                        <select  class="form-select"
                        aria-label="Default select example"
                         v-model="form.speciality_name" >
                        <option 
                        v-for="especialialidades in specialities"
                           :key="especialialidades.speciality_name"

                       >{{especialialidades.speciality_name}}</option>
                      </select>


                        <span class="error"></span>
                      </div>


                      <div class="form-group col-md my-5">
                        <button
                          class="btn btn-info agregar"
                          v-on:click="guardar()"
                        >
                          Agregar
                        </button>
                      </div>

                        <div class="alert alert-danger" role="alert" v-if="register">
                            {{error}}
                        </div>

                    </form>
                  </div>
                </div>
              </div>
            </section>
        </div>
      </div>
    </section>
  </section>
</template>



<script>
import axios from "axios";
import { Card } from "@/components/index";
import Servicio from "../components/Servicio.vue";

export default {
  components: {
    Card,
    Servicio,
  },

  data() {
    return {
      specialities:[],
      patients:[],

      query:"",
      error:"",

      form: {
        patient_name: "",
        speciality_name: "",
      },
    };
  },
  mounted(){

    this.Especialidades();
    this.MostrarPatients();

  },

  methods: {
    guardar() {
      axios
        .post("http://127.0.0.1:8000/api/patient-specialities/v1", this.form)
        .then((data) => {
          console.log(data);

          if (data.status === 201) {
            this.$swal({
              position: "top-end",
              title: "se guardó correctamente!!",
              icon: "success",
              timer: "2000",
              toast: "true",
            });
            this.$router.push("/asignarEspecialidad");
          } else {

            this.register = true
            this.error = datos.data.error



          }
        });
    },

    Especialidades(){
      axios
      .get("http://127.0.0.1:8000/api/specialities/v1")
      .then(datos =>{
        console.log(datos)
        this.specialities = datos.data.specialities
      })
    },


    MostrarPatients(){
      axios
      .get("http://127.0.0.1:8000/api/patients/v1")
      .then(datos =>{
        console.log(datos)
        this.patients = datos.data.patients
      })
    },
  },
};

</script>
<style lang="sass" scoped>


$mainFont: 'Raleway', sans-serif
$subFont: 'Montserrat', sans-serif

// Color Scheme
$primaryColor: #f95959
$secondaryColor: #f7edd5
$inputColor: #bbbbbb



.form
  position: relative

  .form-peice
    background: #fff
    min-height: 480px
    margin-top: 30px
    box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2)
    color: $inputColor
    padding: 30px 0 60px
    transition: all 0.9s cubic-bezier(1.000, -0.375, 0.285, 0.995)
    position: absolute
    top: 0
    left: -29%
    width: 130%
    overflow: hidden
    &.switched
      transform: translateX(-100%)
      width: 80%
      left: 0

  form
    padding: 0 40px
    margin: 0
    width: 70%
    position: absolute
    top: 50%
    left: 60%
    transform: translate(-50%, -50%)

    .form-group
      margin-bottom: 5px
      position: relative
      &.hasError
        input
          border-color: $primaryColor !important
          label
            color: $primaryColor !important

      label
        font-size: 12px
        font-weight: 400
        text-transform: uppercase
        font-family: $subFont
        transform: translateY(40px)
        transition: all 0.4s
        cursor: text
        z-index: -1
        &.active
          transform: translateY(10px)
          font-size: 10px
        &.fontSwitch
          font-family: $mainFont !important
          font-weight: 600

      input:not([type=submit])
        background: none
        outline: none
        border: none
        display: block
        padding: 10px 0
        width: 100%
        border-bottom: 1px solid #eee
        color: #444
        font-size: 15px
        font-family: $subFont
        z-index: 1
        &.hasError
          border-color: $primaryColor

</style>
