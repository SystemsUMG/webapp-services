<template>
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      	<div class="container-fluid py-1 px-3">
        	<nav aria-label="breadcrumb">
          		<h6 class="font-weight-bolder text-white mb-0">Panel de Administración</h6>
        	</nav>
        	<div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
				<ul class="navbar-nav ms-md-auto justify-content-end">
					<li class="nav-item d-flex align-items-center">
						<router-link :to="{ name: 'Profile' }" class="nav-link text-white font-weight-bold px-0">
							<i class="fa fa-user me-sm-2"></i>
							<span class="d-sm-inline d-none">Perfil</span>
						</router-link>
					</li>
					<li class="nav-item d-xl-none ps-3 d-flex align-items-center">
						<a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
							<div class="sidenav-toggler-inner">
								<i class="sidenav-toggler-line bg-white"></i>
								<i class="sidenav-toggler-line bg-white"></i>
								<i class="sidenav-toggler-line bg-white"></i>
							</div>
						</a>
					</li>
					<li class="nav-item px-4 d-flex align-items-center">
						<a @click="logout()" class="nav-link text-white font-weight-bold px-0 cursor-pointer">
							<i class="fa fa-power-off me-sm-2"></i>
							<span class="d-sm-inline d-none">Cerrar Sesión</span>
						</a>
					</li>
				</ul>
        	</div>
      	</div>
    </nav>
</template>
<script>
export default {
	methods: {
		logout() {
			axios({url: 'logout', method: 'POST' })
			.then((resp) => {
				localStorage.removeItem('token')
				localStorage.removeItem('user')
				// this.$router.push({ name: 'Login' })
				window.location.reload('/login')
			})
		}
	}
}
</script>