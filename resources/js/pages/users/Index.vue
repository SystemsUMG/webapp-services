<template>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
			<div class="card-header pb-0">
				<div class="row">
					<div class="col">
						<h6>Tabla de Usuarios</h6>
					</div>
					<div class="col text-end">
						<button type="button" @click="OPEN('POST')" class="btn btn-dark btn-sm mb-3">Crear Usuario</button>
					</div>
				</div>
			</div>
			<div class="card-body px-0 pt-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center mb-0">
						<thead>
							<tr>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cargo</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Región</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">País</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
							</tr>
						</thead>
						<tbody v-if="show">
							<tr v-for="user in users" :key="user.id">
								<td>
									<div class="d-flex px-3 py-1">
										<div class="d-flex flex-column justify-content-center">
											<h6 class="mb-0 text-sm">{{ user.name }}</h6>
											<p class="text-xs text-secondary mb-0">{{ user.email }}</p>
										</div>
									</div>
								</td>
								<td>
									<p class="text-xs font-weight-bold mb-0">{{ user.rol }}</p>
									<p class="text-xs text-secondary mb-0">{{ user.department }}</p>
								</td>
								<td>
									<div class="px-3">
										<span class="text-secondary text-xs font-weight-bold">{{ user.region }}</span>
									</div>
								</td>
								<td>
									<div class="px-3">
										<span class="text-secondary text-xs font-weight-bold">{{ user.country }}</span>
									</div>
								</td>
								<td class="px-3 text-sm">
									<span class="badge badge-sm bg-gradient-success">Online</span>
								</td>
								<td class="align-middle">
									<a  class="text-success font-weight-bold text-xs"  @click="OPEN('PUT', user.id)">Editar</a>
									&nbsp;
									<a class="text-danger font-weight-bold text-xs" @click="OPEN('DELETE', user.id)">Eliminar</a>
								</td>
							</tr>
						</tbody>
						<tbody v-else>
							<tr>
								<td class="text-center py-5" colspan="6">
									<p>No hay usuarios registrados</p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
        </div>
    </div>
</div>
<data-form v-if="get_open" :open="get_open" :method="method" :id="id" @close="loadData()"/>
<data-delete v-if="get_delete" :open="get_delete" :id="id" @close="loadData()"/>
</template>
<script>
import axios from "axios";
import DataForm from './Form.vue';
import DataDelete from './Delete.vue';
export default {
    components: { DataForm, DataDelete },
	data() {
		return {
			users: [],
            error: '',
            loader: {},
            show: false,
			get_delete: false,
            get_open: false,
            method: '',
            id: ''
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
		showLoader() {
            this.loader = this.$loading.show({
                container:  null,
                canCancel: false,
				color: '#5E72E4',
				backgroundColor: '#808080'
            });
        },
		hideLoader() {
			this.loader.hide();
		},
        loadData(){
			let _this = this
			let icon = 'error'

            _this.get_delete = false
			_this.get_open = false
			_this.showLoader()

			setTimeout(
				function() {
					axios({url: 'users' , method: 'GET'})
					.then((resp) => {
						if(resp.data.records.length > 0) {
							_this.show = true
							_this.users = resp.data.records
							icon = 'success'
							_this.error = resp.data.message
						} else {
							icon = 'warning'
							_this.error = 'No existen registros'
						}
						_this.showToast(icon, _this.error)
					}).catch((err) => {
						_this.showToast(icon)
					})
					_this.hideLoader()
				},
				1000
			)
        },
		OPEN: function(method, id = null){
            this.method = method
            this.id = id
            if(method == 'DELETE') {
                this.get_delete = true
            } else {
                this.get_open = true
            }
        }
	}
}
</script>