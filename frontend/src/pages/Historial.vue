<template>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <card type="chart">
          <template slot="header">
            <div class="row">
              <div class="col-sm-6">
                <template>
                  <h5 class="card-category">Historial</h5>
                </template>

                <template>
                  <h2 class="card-title">Historial</h2>
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
        
          <section class="row">
            <div class="col">
              <div class="card">
                
                <div class="card-body table-responsive-lg">
                  <table class="table table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Identificacion</th>
                        <th>Servicio</th>
                        <th>Especialidad</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="">
                        <td>Id</td>
                        <td>darly</td>
                        <td>1002965382</td>
                        <td>Urgencias</td>
                        <td>Paramedico</td>
                        
                      </tr>

                      <tr class="">
                        <td>Id</td>
                        <td>darly</td>
                        <td>1002965382</td>
                        <td>Urgencias</td>
                        <td>Paramedico</td>
                        
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
import { Card } from "@/components/index";
export default{
  components:{
    Card
  },
  data(){
    return{
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
    }
  }
};
</script>
<style>
</style>