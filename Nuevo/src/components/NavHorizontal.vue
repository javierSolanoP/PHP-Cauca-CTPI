<template>


 
        <div >
            <aside class="navbar-nav bg-gradient-info sidebar sidebar-dark " id="accordionSidebar">


                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                        <div class="sidebar-brand-icon rotate-n-15">
                        </div>
                        <div class="sidebar-brand-text mx-3">Administrador</div>
                    </a>

           
            <hr class="sidebar-divider my-0">

            <!--Items de Dashboard -->

            <li class="nav-item active">
                <a class="nav-link">
                    <span>Sistema MultiTenant</span></a>
            </li>


            <hr class="sidebar-divider">


            <div class="sidebar-heading">
                Facturación
            </div>

           
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">

                    <span>Transacciones</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="py-1 collapse-inner rounded">
                        <h6 class="collapse-header">Proceso de ventas</h6>
                        <a class="collapse-item text-light" >Proceso de compras</a>
                        <a class="collapse-item text-light" >Inventarios</a>
                    </div>
                </div>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" >
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Opción unica</span></a>
            </li> -->



            <hr class="sidebar-divider d-none d-md-block">


            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
            </div>

            </aside>
    
    </div>

    
</template>






<script >


// 






export default {
   

}



</script>

<style scoped src="@/css/estylo.css">

</style>
