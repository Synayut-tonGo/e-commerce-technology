import { createRouter, createWebHistory } from "vue-router";
import LoginView from "@/views/Auth/LoginView.vue";
import DashboardView from "@/views/DashboardView.vue";

const routes = [
    {
       name: "Dashboard", 
       path: "/dashboard",
       component: DashboardView
    },
    {
       name: "Login", 
       path: "/login",
       component: LoginView
    },    
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router