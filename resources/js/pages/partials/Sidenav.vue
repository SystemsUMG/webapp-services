<template>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      	<i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      	<router-link class="navbar-brand m-0" :to="{ name: 'Home' }">
      	  	<img :src="'/img/logoRH.png'" class="navbar-brand-img h-100" alt="main_logo">
      	  	<span class="ms-1 font-weight-bold">Control de Personal</span>
      	</router-link>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main" style="height: inherit">
      	<ul class="navbar-nav">
        	<li class="nav-item">
        	  	<router-link class="nav-link" :to="{ name: 'Home' }">
        	    	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        	    	  	<i class="ni ni-chart-bar-32 text-primary text-sm opacity-10"></i>
        	    	</div>
        	    	<span class="nav-link-text ms-1">Dashboard</span>
        	  	</router-link>
        	</li>
        	<li class="nav-item">
        	  	<router-link class="nav-link " :to="{ name: 'Users' }">
        	  	  	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        	  	  	  	<i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
        	  	  	</div>
        	  	  	<span class="nav-link-text ms-1">Usuarios</span>
        	  	</router-link>
        	</li>
        	<li class="nav-item">
        	  	<router-link class="nav-link " :to="{ name: 'Countries' }">
        	  	  	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        	  	    	<i class="ni ni-world text-info text-sm opacity-10"></i>
        	  	  	</div>
        	  	  	<span class="nav-link-text ms-1">Países</span>
        	  	</router-link>
        	</li>
        	<li class="nav-item">
        	  	<router-link class="nav-link " :to="{ name: 'Departments' }">
        	  	  	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        	  	  	  	<i class="ni ni-square-pin text-success text-sm opacity-10"></i>
        	  	  	</div>
        	  	  	<span class="nav-link-text ms-1">Departamentos</span>
        	  	</router-link>
        	</li>
        	<li class="nav-item">
        	  	<router-link class="nav-link " :to="{ name: 'Regions' }">
        	  	  	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        	  	  	 	<i class="ni ni-world-2 text-primary text-sm opacity-10"></i>
        	  	  	</div>
        	  	  	<span class="nav-link-text ms-1">Regiones</span>
        	  	</router-link>
        	</li>
        	<li class="nav-item">
        	  	<router-link class="nav-link " :to="{ name: 'Roles' }">
        	  	  	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        	  	  	  	<i class="ni ni-circle-08 text-danger text-sm opacity-10"></i>
        	  	  	</div>
        	  	  	<span class="nav-link-text ms-1">Puestos</span>
        	  	</router-link>
        	</li>
        	<li class="nav-item mt-3">
        		<h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Información Personal</h6>
        	</li>
        	<li class="nav-item">
        	  	<router-link class="nav-link " :to="{ name: 'Profile' }">
        	  	  	<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
        	  	  	  	<i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
        	  	  	</div>
        	  	  	<span class="nav-link-text ms-1">Perfil</span>
        	  	</router-link>
        	</li>
      	</ul>
    </div>
</aside>
</template>
<script>
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
  	var options = {
    	damping: '0.5'
  	}
  	Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script>
