<template>
  	<div class="h-100 bg-primary position-fixed w-100" v-if="show"></div>
  	<sidenav v-if="show"></sidenav>
  	<main class="main-content position-relative border-radius-lg">
    	<navbar v-if="show"></navbar>
    	<div class="container-fluid pt-4">
      		<router-view />
    	</div>
    	<bottom v-if="show"></bottom>
  	</main>
</template>

<script>
import Navbar from "./pages/partials/Navbar.vue";
import Bottom from "./pages/partials/Bottom.vue";
import Sidenav from "./pages/partials/Sidenav.vue";

export default {
	name: "App",
	components: {
    	Navbar,
    	Bottom,
    	Sidenav
	},
	data() {
		return {
			show: false,
        }
    },
	created() {
		const token = localStorage.getItem('token')
		this.show = token ? true : false
	}
}
</script>