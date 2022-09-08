import { createRouter, createWebHistory } from "vue-router";
import home from "./pages/home.vue";
import Users from "./pages/users/Index.vue";
import Profile from "./pages/profile/Profile.vue";
// import Departments from "./pages/users/Countries.vue";
// import Countries from "./pages/users/Countries.vue";


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
    // {
    //     path: "/paises",
    //     name: "Countries",
    //     component: Countries
    // },
    // {
    //     path: "/departamentos",
    //     name: "Departments",
    //     component: Departments
    // },
];

const history = createWebHistory();

const router = createRouter(
    {
        history,
        routes,
    }
);

export default router;