<template>

        <div class="container ">
            <article class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-12">
                    <div class="card o-hidden border-0 shadow-lg mt-5">
                        <div class="card-body p-0">
                            <div class="row">

                                <div class="col-lg-6 d-none  d-lg-block">
                                    <img  class="my-5" src="@/assets/logos.svg" style="width:500px;">
                                </div>

                                <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenidos!</h1>
                                    </div>
                                            <form class="user" v-on:submit.prevent="login">
                                                <div class="form-group">
                                                  <label for="">Email</label>
                                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="ejemplo@....." v-model="usuario">
                                                </div>

                                                <div class="form-group">
                                                  <label for="">Contraseña</label>
                                                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="************" v-model="password">
                                                </div>
                                            
                                                <button type="submit" class="btn btn-info  btn-user btn-block">  Iniciar </button>

                                                <hr />

                                                <a  class="btn btn-light google btn-user btn-block border-secondary">
                                                  <img src="@/assets/gmail.png" style="width:20px;">
                                                  Iniciar con Gmail
                                                </a>
                                  
                                            </form>

                                            <br>

                                       

                                        <div class="alert alert-danger" role="alert" v-if="error">
                                            {{ error_msg }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
 
</template>

<script>

import axios from 'axios'

export default {
  name: "Home",

  data() {
    return{
    

      usuario :"",
      password:"",
      error:"",
      error_msg:"",

      json:[],

      
    }
    

  },

  methods:{
    login(){

      let json={
        usuario:  this.usuario,
        password: this.password,
      };

      axios
      .post('https://api.solodata.es/auth',json)
      .then( (datos) =>{
        console.log(datos);
        sessionStorage.setItem(json, JSON.stringify(datos.data));

        if(datos.data.status == "ok"){
          sessionStorage.token = datos.data.result.token;
          let tokenStorage = localStorage.token;
          this.$router.push('about')
          console.log(tokenStorage)

        }else{
          this.error = true
          this.error_msg = datos.data.result.error_msg
        }
      })
    }
  },
  mounted(){
    if(sessionStorage.getItem(this.json)){
      this.json = JSON.parse(sessionStorage.getItem(this.json))

    }
  }
  
};
</script>



<style scoped src="@/css/estylo.css"> 


template{
  background-color: black  !important;
}

.logo{
  margin: 0px 50px;
}


</style>

