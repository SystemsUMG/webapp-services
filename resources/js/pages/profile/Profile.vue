<template>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 container">
        <div class="card mx-5">
            <img :src="'/img/bg1.jpg'" alt="Image placeholder" class="card-img-top">
        	<div class="row justify-content-center">
				<div class="col-4 col-lg-4 order-lg-2">
					<div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
						<img :src="'/img/user.svg'"  class="rounded-circle img-fluid border border-2 border-white">
					</div>
				</div>
    		</div>
    		<div class="card-body pt-0">
        		<div class="text-center mt-4">
            		<h5>{{ user.name }}<span class="font-weight-light">, {{ user.age }} años</span></h5>
					<h6 class="font-weight-300">{{ user.email }}</h6>
					<h6 class="font-weight-300">{{ user.rol_id }} - {{ user.department_id }}</h6>
					<p class="mt-4 mb-0">{{ user.address }}</p>
					<h6>{{ user.region_id }}, {{ user.country_id }}</h6>
        		</div>
    		</div>
		</div>
    </div>
</div>
</template>
<script>
export default {
	data() {
		return {
			icon: '',
			message: '',
			loader: {},
			id: '',
			user: {
				name: '',
				email: '',
				password: '',
				age: '',
				address: '',
				region_id: '',
				rol_id: '',
				department_id: '',
				country_id: ''
			},
			roles: [],
            departments: [],
            regions: [],
            countries: [],
		}
	},
	mounted() {
		this.loadData('rols')
    	this.loadData('departments')
        this.loadData('regions')
        this.loadData('countries')
		this.loadUser()
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
		loadData(url = '') {
            let _this = this
            axios({url: url , method: 'GET'})
			.then((resp) => {
			    if(resp.data.records.length > 0) {
                    let records = resp.data.records
                    switch(url) {
                    case 'rols':
                        _this.roles = records
                        break;
                    case 'departments':
                        _this.departments = records
                        break;
                    case 'regions':
                        _this.regions = records
                        break;
                    case 'countries':
                        _this.countries = records
                        break;
                    default:
                        _this.roles = records
                    }
				} else {
					_this.icon = 'error'
					_this.message = 'No existen ' + url + ' registrados'
					_this.showToast(_this.icon, _this.message)
				}
			}).catch((err) => {
				_this.showToast(_this.icon)
			})
        },
		loadUser() {
			let _this = this
			_this.showLoader(true)

			_this.id = localStorage.getItem('user')
			setTimeout(
				function() {
					axios({url: '/users/' + _this.id, method: 'GET'})
					.then((resp) => {
						if(resp.data.result) {
							let user = resp.data.records
							user.rol_id = _this.foundData(_this.roles, user.rol_id)
							user.department_id = _this.foundData(_this.departments, user.department_id)
							user.region_id = _this.foundData(_this.regions, user.region_id)
							user.country_id = _this.foundData(_this.countries, user.country_id)
							_this.user = user
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
		foundData(data = [], element) {
			let property = ''
			data.forEach(function(item) {
				if (item.id == element) {
					property = item.name
				}
			})
			return property
		}
	}
}
</script>
