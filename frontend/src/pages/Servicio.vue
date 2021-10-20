<template>
  <div class="content">
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
                  <h2 class="card-title">Servicios</h2>
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
                <button class="btn btn-info agregar">Agregar</button>
            </template>
          </h4>

          <section class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nombre</th>
        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        
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
import { Card } from "@/components/index";

export default {
  components: {
    Card,
  },
};
</script>
<style  scoped>



th{
  color: aliceblue  !important;
}

</style>
