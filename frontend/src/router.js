import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";
import Dashboard from "@/pages/Dashboard.vue";
import Historial from "@/pages/Historial.vue";
import Addppersonal from "@/pages/Addppersonal.vue";
import UserProfile from "@/pages/UserProfile.vue";
import Profesion from "@/pages/Profesion.vue";



const routes = [{
  path: "/",
  component: DashboardLayout,
  redirect: "dashboard",
  children:[
    {
      path: "dashboard",
      name: "Programar Turno",
      component: Dashboard
    },
    {
      path: "historial",
      name: "Historial",
      component: Historial
    },
    {
      path: "addppersonal",
      name: " Agregar Personal",
      component: Addppersonal
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
    }
  ]

}]

export default routes;
