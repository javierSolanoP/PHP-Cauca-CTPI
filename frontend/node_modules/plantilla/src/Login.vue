<template>

  <section class="bg-gradient-info "> 
        <div class="container">
            <article class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">

                                <div class="col-lg-6 d-none d-lg-block">
                                    <img>
                                </div>

                                <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenidos!</h1>
                                    </div>
                                            <form class="user">
                                                <div class="form-group">
                                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Emaill..."/>
                                                </div>

                                                <div class="form-group">
                                                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Contraseña"/>
                                                </div>
                                            
                                                <a href="index.html" class="btn btn-primary btn-user btn-block">  Iniciar </a>

                                                <hr />

                                                <a href="index.html" class="btn btn-google btn-user btn-block">Iniciar con Gmail</a>
                                                <a href="index.html" class="btn btn-facebook btn-user btn-block">

                                                <i class="fab fa-facebook-f fa-fw"></i> Iniciar con facebook</a>

                                            </form>

                                        <hr />

                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Olvidaste Contraseña?</a>
                                        </div>

                                        <div class="text-center">
                                            <a class="small" href="register.html">Crear Cuenta!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
  </section>
</template>

<script>


export default {
  name: "Login",

  data() {},
};
</script>



<style scoped src="@/css/estylo.css"> 


section{
height: 100vh;
}

</style>
