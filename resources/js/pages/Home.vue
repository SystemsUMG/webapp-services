<template>
  	<div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          	<div class="card">
            	<div class="card-body p-3">
              		<div class="row">
                		<div class="col-8">
							<div class="numbers">
								<p class="text-sm mb-0 text-uppercase font-weight-bold">Usuarios</p>
								<h5 class="font-weight-bolder">{{ totals.total_users }}</h5>
							</div>
                		</div>
                		<div class="col-4 text-end">
                  			<div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    			<i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                  			</div>
                		</div>
              		</div>
            	</div>
        	</div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        	<div class="card">
            	<div class="card-body p-3">
              		<div class="row">
                		<div class="col-8">
                  			<div class="numbers">
                    			<p class="text-sm mb-0 text-uppercase font-weight-bold">Países</p>
                    			<h5 class="font-weight-bolder">{{ totals.total_countries }}</h5>
                  			</div>
                		</div>
                		<div class="col-4 text-end">
                  			<div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    			<i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  			</div>
                		</div>
              		</div>
            	</div>
        	</div>
    	</div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          	<div class="card">
            	<div class="card-body p-3">
              		<div class="row">
              		  	<div class="col-8">
              		    	<div class="numbers">
              		      		<p class="text-sm mb-0 text-uppercase font-weight-bold">Departamentos</p>
              		      		<h5 class="font-weight-bolder">{{ totals.total_departments }}</h5>
              		    	</div>
              		  	</div>
              			<div class="col-4 text-end">
							<div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
								<i class="ni ni-square-pin text-lg opacity-10" aria-hidden="true"></i>
							</div>
           				</div>
        			</div>
            	</div>
          	</div>
        </div>
        <div class="col-xl-3 col-sm-6">
          	<div class="card">
          	  	<div class="card-body p-3">
          	  	  	<div class="row">
          	  	  	  	<div class="col-8">
          	  	  	  	  	<div class="numbers">
          	  	  	  	  	  	<p class="text-sm mb-0 text-uppercase font-weight-bold">Regiones</p>
          	  	  	  	  	  	<h5 class="font-weight-bolder">{{ totals.total_departments }}</h5>
          	  	  	  	  	</div>
          	  	  	  	</div>
          	  	  	  	<div class="col-4 text-end">
          	  	  	  	  	<div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
          	  	  	  	    	<i class="ni ni-world-2 text-lg opacity-10" aria-hidden="true"></i>
          	  	  	  	  	</div>
          	  	  	  	</div>
          	  	  	</div>
          		</div>
          	</div>
        </div>
	</div>
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          	<div class="card z-index-2 h-100">
            	<div class="card-header pb-0 pt-3 bg-transparent">
              		<h6 class="text-capitalize">Resumen de Usuarios</h6>
              		<p class="text-sm mb-0">Cantidad de usuarios en cada país</p>
            	</div>
            	<div class="card-body p-3">
					<line-chart :labels="labels" :values="values" v-if="show" style="height: 300px"/>
            	</div>
          	</div>
        </div>
        <div class="col-lg-5">
          	<div class="card card-carousel overflow-hidden h-100 p-0">
            	<div id="carouselInfo" class="carousel slide h-100" data-bs-ride="carousel">
              		<div class="carousel-inner border-radius-lg h-100">
                		<div class="carousel-item h-100 active" style="background-image: url('./img/carousel-1.jpg'); background-size: cover;">
                  			<div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    			<div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      				<i class="ni ni-circle-08 text-dark opacity-10"></i>
                    			</div>
                    			<h5 class="text-white mb-1">Bienvenido</h5>
                    			<p>Administración de usuarios de manera sencilla.</p>
                  			</div>
                		</div>
                		<div class="carousel-item h-100" style="background-image: url('./img/carousel-2.jpg'); background-size: cover;">
                  			<div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    			<div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      				<i class="ni ni-tag text-dark opacity-10"></i>
                    			</div>
                    			<h5 class="text-white mb-1">Gestión de Puestos</h5>
                    			<p>La administración de puestos de trabajo nunca había sido tan fácil.</p>
                  			</div>
                		</div>
                		<div class="carousel-item h-100" style="background-image: url('./img/carousel-3.jpg'); background-size: cover;">
                  			<div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    			<div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      				<i class="ni ni-chart-bar-32 text-dark opacity-10"></i>
                    			</div>
                    			<h5 class="text-white mb-1">Generación de Gráficos</h5>
                    			<p>Estadísticas de usuarios en tiempo real.</p>
                  			</div>
                		</div>
              		</div>
					<button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselInfo" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Anterior</span>
					</button>
					<button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselInfo" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Siguiente</span>
					</button>
            	</div>
          	</div>
        </div>
    </div>
</template>

<script>
import LineChart from './LineChart.vue'

export default {
  	components: { LineChart },
	data() {
		return {
			icon: '',
            message: '',
            totals: '',
            loader: {},
			show: false,
			labels: [],
			values: []
        }
    },
	mounted() {
		this.loadData()
	},
	methods: {
		showToast(icon = "error", message = "Ocurrió un error, por favor vuelva a intentar") {
            const Toast = this.$swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', this.$swal.stopTimer)
					toast.addEventListener('mouseleave', this.$swal.resumeTimer)
				}
			})
			Toast.fire({
				icon: icon,
				title: message
			})
        },
		showLoader(show = false) {
			if (show) {
				this.loader = this.$loading.show({
					container:  null,
					canCancel: false,
					color: '#000000',
					backgroundColor: '#808080'
				})
			} else {
				this.loader.hide()
			}
        },
        loadData(){
			let _this = this
			_this.showLoader(true)

			setTimeout(
				function() {
					axios({url: 'graphics/users' , method: 'GET'})
					.then((resp) => {
						if(resp.data.records.countries.length > 0) {
							_this.labels = resp.data.records.countries
							_this.values = resp.data.records.users_real
							_this.totals = resp.data.records.totals
							_this.show = true
							_this.icon = 'success'
							_this.message = resp.data.message
						} else {
							_this.icon = 'warning'
							_this.message = 'No existen registros'
						}
						_this.showToast(_this.icon, _this.message)
					}).catch((err) => {
						_this.icon = 'error'
						_this.showToast(_this.icon)
					})
					_this.showLoader(false)
				},
				300
			)
        },
	}
}
</script>
