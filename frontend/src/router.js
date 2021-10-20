import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";
import Dashboard from "@/pages/Dashboard.vue";
import Historial from "@/pages/Historial.vue";
import Addppersonal from "@/pages/Addppersonal.vue";
import UserProfile from "@/pages/UserProfile.vue";
import Profesion from "@/pages/Profesion.vue";
import Especialidades from "@/pages/Especialidades.vue";
import Servicios from "@/pages/Servicios.vue";



const routes = [{
  path: "/",
  component: DashboardLayout,
  redirect: "dashboard",
  children:[
    {
      path: "addppersonal",
      name: " Agregar Servicio",
      component: Addppersonal
    },
    {
      path: "dashboard",
      name: "Programar Turno",
      component: Dashboard
    },
    {
      path: "especialidades",
      name: "Especialidades",
      component: Especialidades
    },
    {
      path: "servicios",
      name: "Servicios",
      component: Servicios
    },
    
    {
      path: "user",
      name: "Perfil de Usuario",
      component: UserProfile
    },
    

    {
      path: "profesion",
      name: "Profesion",
      component: Profesion
    },
    {
      path: "historial",
      name: "Historial",
      component: Historial
    }
  ]

}]

export default routes;
