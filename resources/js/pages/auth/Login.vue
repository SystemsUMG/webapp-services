<template>
    <main class="main-content mt-0">
		<section>
			<div class="page-header min-vh-95">
				<div class="container">
					<div class="row">
						<div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
							<div class="card card-plain">
								<div class="card-header pb-0 text-start">
									<h4 class="font-weight-bolder">Iniciar Sesión</h4>
									<p class="mb-0">Ingresa tus credenciales para acceder</p>
								</div>
								<div class="card-body">
									<form role="form"  @submit.prevent="login()">
										<div class="mb-3">
											<input type="email" class="form-control form-control-lg" placeholder="Email" v-model="data.email">
										</div>
										<div class="mb-3">
											<input type="password" class="form-control form-control-lg" placeholder="Contraseña" v-model="data.password">
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Iniciar Sesión</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
							<div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
								<span class="mask bg-gradient-primary opacity-6"></span>
								<h4 class="mt-5 text-white font-weight-bolder position-relative">Sistema de Control de Personal</h4>
								<p class="text-white position-relative">Gestiona a los empleados y administra información de personal.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
</template>
<script>
import axios from "axios";

export default {
    data(){
        return {
			count: 0,
			icon: '',
            message: '',
			loader: {},
            data: {
                email: '',
                password: '',
            },
        }
    },
    methods:{
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
        login() {
			let _this = this
            _this.count++
            if(_this.count == 1) {
				_this.showLoader(true)
                axios({url: '/login', method: 'POST', data: this.data })
                .then((resp) => {
					if(resp.data.result) {
						const token = resp.data.records.token
						const user = resp.data.records.user_id
                        localStorage.setItem('token', token)
                        localStorage.setItem('user', user)
						this.$router.push({ name: 'Home' })
						window.location.reload('/')
					} else {
                        _this.icon = 'error'
						_this.message = resp.data.message
						_this.showToast(_this.icon, _this.message)
					}
                    _this.count = 0
					_this.showLoader(false)
                }).catch((err) => {
					let status = err.response.status
					if (status === 422 || status === 401) {
						_this.icon = 'error'
						_this.message = 'Credenciales incorrectas'
						_this.showToast(_this.icon, _this.message)
                    } else {
						_this.showToast()
                    }
					_this.count = 0
					_this.showLoader(false)
                })
            }
        }
    }
}
</script>