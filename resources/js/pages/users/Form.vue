<template>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :class="OPEN == true ? 'd-block show' : ''">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="SEND()">
                    <div class="d-flex align-items-start px-3">
                        <button type="button " class="btn-close text-dark" @click="CLOSE()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body pt-0 px-4">
                        <hr class="horizontal dark"/>
                        <p class="text-uppercase text-sm">Información Personal</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nombre</label>
                                    <input id="name" class="form-control" type="text" v-model="data.name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Email</label>
                                    <input id="email" class="form-control" type="email" v-model="data.email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-control-label">Contraseña</label>
                                    <input id="password" class="form-control" type="password" v-model="data.password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="age" class="form-control-label">Edad</label>
                                    <input id="age" class="form-control" type="number" v-model="data.age">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Datos Adicionales</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rol_id" class="form-control-label">Puesto</label>
                                    <select  id="rol_id" class="form-select" v-model="data.rol_id">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="rol in roles" :value="rol.id" :key="rol.id">{{ rol.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_id" class="form-control-label">Área</label>
                                    <select  id="department_id" class="form-select" v-model="data.department_id">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="department in departments" :value="department.id" :key="department.id">{{ department.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="form-control-label">Dirección</label>
                                    <input id="address" class="form-control" type="text" v-model="data.address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region_id" class="form-control-label">Región</label>
                                    <select  id="region_id" class="form-select" v-model="data.region_id">
                                        <option value="" disabled hidden>Seleccione una opción</option>
                                        <option v-for="region in regions" :value="region.id" :key="region.id">{{ region.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col mb-2 me-0 text-end">
                                <button @click="CLOSE()" type="button" class="btn btn-secondary btn-sm ms-auto mt-2 mb-0">
                                    <i class="fas fa-times"></i>
                                    <span class="ms-2">Cancelar</span>
                                </button>
                            </div>
                            <div class="col mb-2 ms-0 text-start">
                                <button type="submit" class="btn btn-primary btn-sm ms-auto mt-2 mb-0">
                                    <i class="fas fa-spinner fa-spin me-2" v-if="load"></i>
                                    <span>Guardar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['open', 'method', 'id'],
    data(){
        return {
            icon: '',
            message: '',
            loader: {},
            data: {
                name: '',
                email: '',
                password: '',
                age: '',
                address: '',
                region_id: '',
                rol_id: '',
                department_id: ''
            },
            roles: [],
            departments: [],
            regions: [],
            load: false,
            count: 0,
            url: '',
        }
    },
    computed: {
        OPEN: function() {
            let _this = this
            _this.loadData('rols')
            _this.loadData('departments')
            _this.loadData('regions')
            if(_this.method == 'PUT') {
                axios({url: '/users/' + _this.id, method: 'GET' })
                .then((resp) => {
                    if (resp.data.result) {
                        _this.data = resp.data.records
                    } else {
                        _this.showToast('error', resp.data.message)
                        _this.CLOSE()
                    }
                })
                .catch((err) => {
                    _this.CLOSE()
                    _this.showToast()
                })
            }
            return _this.open
        },
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
                    default:
                        _this.roles = records
                    } 
					_this.icon = 'success'
					_this.message = resp.data.message
				} else {
					_this.icon = 'error'
					_this.message = 'No existen ' + url + ' registrados'
                    _this.CLOSE()
				}
				_this.showToast(_this.icon, _this.message)
			}).catch((err) => {
				_this.showToast(_this.icon)
                _this.CLOSE()
			})
        },
        CLOSE: function(){
            this.$emit('close')
        },
        SEND: function(){
            let _this = this
            _this.count++
            _this.load = true

            let method = _this.method == 'PUT' ? '/' + _this.data.id : ''

            if(_this.count == 1){
                let form = new FormData()
                $.each(this.data, function(key, item) {
                    if(item != null){
                        form.append(key, item)
                    }
                })
                if(this.method == 'PUT'){
                    form.append('_method', 'PUT')
                }

                setTimeout(function() {
					axios({url: '/users' + method, method: 'POST', data: form })
					.then((resp) => {
						if(resp.data.result) {
							_this.icon = 'success'
							_this.message = resp.data.message
                            _this.CLOSE()
                            _this.showToast(_this.icon, _this.message)
						} else {
                            _this.icon = 'error'
                            _this.message = resp.data.message.split("(")[0]
                            _this.showToast(_this.icon, _this.message)
						}
                        _this.load = false
                        _this.count = 0
					}).catch((err) => {
						_this.showToast()
					})
				}, 1000)
            }
        }
    }
}
</script>
