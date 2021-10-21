<template>
  <section class="content">
  
<input 
@change="obtenerDocumento($event)"
type="file"
accept="application/pdf"

>

  </section>
</template>
<script>

import { Card } from "@/components/index";


export default{
  components:{
    Card
  },
  data(){
    return{
      
    }
  },

  methods:{
     obtenerDocumento(event) {
       alert("hola")
       console.log(event.target.files[0])
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
  },

  subirDocumento() {
    const headers = {
      "Content-Type": "multipart/form-data",
    };
    //Creamos el formData
    var data = new FormData();
    //Añadimos la docinscrip seleccionada
    data.append("documento_resolucion", this.docResolucon);
    data.append("id_convocatoria", this.$route.params.id);
    //Enviamos la petición
    axios()
      .post(
        "almacenar_resolucion_convocatoria/" + this.$route.params.id,
        data,
        { headers: headers }
      )
      .then((respuesta) => {
        if ((respuesta.data.status = "success")) {
          Swal.fire({
            title: "Se subió la resolución!",
            text:"Archivo cargado exitosamente!",
            icon: "success",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#238276",
          });
          
        } else {
          Swal.fire(
            "ERROR!",
            "Se ha presentado un error en el servidor!",
            "error"
          );
        }
        this.estadoPeticion = false;
        this.$router.push({ name: "GestionarConvocatoria" });
      });
  }
  }
};
</script>
<style>

icons: [
        // "icon-alert-circle-exc",
        // "icon-align-center",
        // "icon-align-left-2",
        // "icon-app",
        // "icon-atom",
        // "icon-attach-87",
        // "icon-badge",
        // "icon-bag-16",
        // "icon-bank",
        // "icon-basket-simple",
        // "icon-bell-55",
        // "icon-bold",
        // "icon-book-bookmark",
        // "icon-double-right",
        // "icon-bulb-63",
        // "icon-bullet-list-67",
        // "icon-bus-front-12",
        // "icon-button-power",
        // "icon-camera-18",
        // "icon-calendar-60",
        // "icon-caps-small",
        // "icon-cart",
        // "icon-chart-bar-32",
        // "icon-chart-pie-36",
        // "icon-chat-33",
        // "icon-check-2",
        // "icon-cloud-download-93",
        // "icon-cloud-upload-94",
        // "icon-coins",
        // "icon-compass-05",
        // "icon-controller",
        // "icon-credit-card",
        // "icon-delivery-fast",
        // "icon-email-85",
        // "icon-gift-2",
        // "icon-globe-2",
        // "icon-headphones",
        // "icon-heart-2",
        // "icon-html5",
        // "icon-double-left",
        // "icon-image-02",
        // "icon-istanbul",
        // "icon-key-25",
        // "icon-laptop",
        // "icon-light-3",
        // "icon-link-72",
        // "icon-lock-circle",
        // "icon-map-big",
        // "icon-minimal-down",
        // "icon-minimal-left",
        // "icon-minimal-right",
        // "icon-minimal-up",
        // "icon-mobile",
        // "icon-molecule-40",
        // "icon-money-coins",
        // "icon-notes",
        // "icon-palette",
        // "icon-paper",
        // "icon-pin",
        // "icon-planet",
        // "icon-puzzle-10",
        // "icon-pencil",
        // "icon-satisfied",
        // "icon-scissors",
        // "icon-send",
        // "icon-settings-gear-63",
        // "icon-settings",
        // "icon-wifi",
        // "icon-single-02",
        // "icon-single-copy-04",
        // "icon-sound-wave",
        // "icon-spaceship",
        // "icon-square-pin",
        // "icon-support-17",
        // "icon-tablet-2",
        // "icon-tag",
        // "icon-tap-02",
        // "icon-tie-bow",
        // "icon-time-alarm",
        // "icon-trash-simple",
        // "icon-trophy",
        // "icon-tv-2",
        // "icon-upload",
        // "icon-user-run",
        // "icon-vector",
        // "icon-video-66",
        // "icon-wallet-43",
        // "icon-volume-98",
        // "icon-watch-time",
        // "icon-world",
        // "icon-zoom-split",
        // "icon-refresh-01",
        // "icon-refresh-02",
        // "icon-shape-star",
        // "icon-components",
        // "icon-triangle-right-17",
        // "icon-button-pause",
        // "icon-simple-remove",
        // "icon-simple-add",
        // "icon-simple-delete"
      ],
</style>
