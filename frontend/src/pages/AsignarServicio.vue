<template>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <card type="chart">
          <template slot="header">
            <div class="row">
              <div class="col-sm-6">
                <template>
                  <h5 class="card-category">Enfermeras</h5>
                </template>

                <template>
                  <h2 class="card-title">Agregar Enfermeras</h2>
                </template>
              </div>
            </div>
          </template>
        </card>
      </div>
    </div>

    <section class="content dos">
      <div class="row">
        <div class="col-lg-12 col-md-12">

            <section class="row">
              <div class="col">
                <div class=" cardcol-sm-6 form">
                  <div class=" form-peice">
                    <form>


                      <div class="form-group">
                        <label for="name">Nombre</label>
                        <input placeholder="*" required type="text" v-model="form.name" />
                        <span class="error"></span>
                      </div>

                      <div class="form-group">
                        <label >Apellidos</label>
                        <input placeholder="*" required  type="text" v-model="form.last_name" />
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
      error:"",
      
      form: {
        name: "",
        last_name: "",
        role: "",
        identification: "",
        email:"",
        password:"",
        confirmPassword:""

      },
    };
  },

  methods: {
    guardar() {
      axios
        .post("http://127.0.0.1:8000/api/nurses/v1", this.form)
        .then((data) => {
          console.log(data);

          if ((data.status == 201)) {
            this.$swal({
              position: "top-end",
              title: "se guardó correctamente!!",
              icon: "success",
              timer: "2000",
              toast: "true",
            });
            this.$router.push("/enfermeras");
          } else {

          }
        })
        .catch(() => {
            this.$swal({
              icon: 'error',
              title: 'Oops...',
              text: 'error al Guardar!',
            
            });
        });
        
    },
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
          text: "Archivo cargado exitosamente!",
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
    min-height: 800px
    margin-top: 30px
    box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2)
    color: $inputColor
    padding: px 0 px
    transition: all 0.9s cubic-bezier(1.000, -0.375, 0.285, 0.995)
    position: absolute
    top: 0
    
    width: 100%
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
    left: 50%
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
