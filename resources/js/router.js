import { createRouter, createWebHistory } from "vue-router";
import home from "./pages/home.vue";
import Users from "./pages/users/Index.vue";
import Profile from "./pages/profile/Profile.vue";
import Countries from "./pages/countries/Index.vue";
import Departments from "./pages/departments/Index.vue";
import Regions from "./pages/regions/Index.vue";
import Roles from "./pages/roles/Index.vue";


const routes = [
    {
        path: "/",
        name: "Home",
        component: home
    },
    {
        path: "/usuarios",
        name: "Users",
        component: Users
    },
    {
        path: "/perfil",
        name: "Profile",
        component: Profile
    },
    {
        path: "/paises",
        name: "Countries",
        component: Countries
    },
    {
        path: "/departamentos",
        name: "Departments",
        component: Departments
    },
    {
        path: "/regiones",
        name: "Regions",
        component: Regions
    },
    {
        path: "/roles",
        name: "Roles",
        component: Roles
    },
];

const history = createWebHistory();

const router = createRouter(
    {
        history,
        routes,
    }
);

export default router;