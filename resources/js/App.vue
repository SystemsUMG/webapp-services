<template>
  	<alert></alert>
  	<div class="h-100 bg-primary position-fixed w-100"></div>
  	<sidenav></sidenav>
  	<main class="main-content position-relative border-radius-lg">
    	<navbar></navbar>
    	<div class="container-fluid pt-4">
      	<router-view />
    	</div>
    	<bottom></bottom>
  	</main>
</template>

<script>
import Navbar from "./pages/partials/Navbar.vue";
import Bottom from "./pages/partials/Bottom.vue";
import Sidenav from "./pages/partials/Sidenav.vue";
import Alert from "./pages/partials/Alert.vue";

export default {
	name: "App",
	components: {
    	Navbar,
    	Bottom,
    	Sidenav,
    	Alert,
	},
}
</script>