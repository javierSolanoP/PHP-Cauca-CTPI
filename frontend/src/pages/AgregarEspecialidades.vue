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
          <section class="row">
            <div class="col">
              <div class="cardcol-sm-6 form">
                <div class="form-peice">
                  <form>
                    <div class="form-group">
                      <label for="name">Nombre servicio</label>
                      <input type="text" v-model="form.speciality_name" />
                      <span class="error"></span>
                    </div>

                    <div class="form-group">
                      <label for="phone">Numero de Dias</label>
                      <input type="text" v-model="form.description" />
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
      form: {
        speciality_name: "",
        description: "",
      },
    };
  },

  methods: {
    guardar() {
      axios
        .post("http://127.0.0.1:8000/api/specialities/v1", this.form)

        .then((data) => {
          this.$swal({
            position: "top-end",
            title: "se guardó correctamente!!",
            icon: "success",
            timer: "2000",
            toast: "true",
          });
          this.$router.push("/especialidades");
          console.log(data);
        });
    },
  },
};
</script>

<style lang="sass" scoped>
// input {
//   width: 80px;
// }

// .agregar{

// background:#11AAB8 !important;
// }

// .agregar:hover{
//   background-color: #11AAB8 !important;
// }

// th{
//   color: aliceblue  !important;
// }

// Fonts
$mainFont: 'Raleway', sans-serif
$subFont: 'Montserrat', sans-serif

// Color Scheme
$primaryColor: #f95959
$secondaryColor: #f7edd5
$inputColor: #bbbbbb

// General Style

// Brand Area
.brand
  padding: 20px
  background: url(https://goo.gl/A0ynht)
  background-size: cover
  background-position: center center
  color: #fff
  min-height: 540px
  position: relative
  box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3)
  transition: all 0.6s cubic-bezier(1.000, -0.375, 0.285, 0.995)
  z-index: 9999

  &.active
    width: 100%

  &::before
    content: ''
    display: block
    width: 100%
    height: 100%
    position: absolute
    top: 0
    left: 0
    background: rgba(0, 0, 0, 0.85)
    z-index: -1
  a.logo
    color: $primaryColor
    font-size: 20px
    font-weight: 700
    text-decoration: none
    line-height: 1em
    span
      font-size: 30px
      color: #fff
      transform: translateX(-5px)
      display: inline-block

  .success-msg
    width: 100%
    text-align: center
    position: absolute
    top: 50%
    left: 50%
    transform: translate(-50%, -50%)
    margin-top: 60px

    p
      font-size: 25px
      font-weight: 400
      font-family: $mainFont

      a
        font-size: 12px
        text-transform: uppercase
        padding: 8px 30px
        background: $primaryColor
        text-decoration: none
        color: #fff
        border-radius: 30px

      p, a
        transition: all 0.9s
        transform: translateY(20px)
        opacity: 0

        &.active
          transform: translateY(0)
          opacity: 1

// Form Area
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

      span.error
        color: $primaryColor
        font-family: $subFont
        font-size: 12px
        position: absolute
        bottom: -20px
        right: 0
        display: none

      input[type=password]
        color: $primaryColor

      .form
        width: 80vw
        min-height: 500px
        margin-left: 10vw
        .form-peice
          margin: 0
          top: 0
          left: 0
          width: 100% !important
          transition: all .5s ease-in-out

          &.switched
            transform: translateY(-100%)
            width: 100%
            left: 0
            > form
              width: 100% !important
              padding: 60px
              left: 50%

@media (max-width: 480px)
  section#formHolder .form
    width: 100vw
    margin-left: 0

  h2
    font-size: 50px !important
</style>
