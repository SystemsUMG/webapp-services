import { createRouter, createWebHistory } from "vue-router";
import Home from "./pages/Home.vue";
import Example from "./pages/Example.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home
    },
    {
        path: "/example",
        name: "Example",
        component: Example
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