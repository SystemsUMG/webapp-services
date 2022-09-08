<template>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :class="OPEN == true ? 'd-block show' : ''">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="SEND()">
                    <div class="d-flex align-items-start px-3 py-1">
                        <button type="button " class="btn-close text-dark" @click="CLOSE()">
                            <i class="fa fa-times"></i>
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto mt-2 mb-0">
                            <i class="fas fa-spinner fa-spin me-2" v-if="load"></i>
                            <span>Guardar</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0 px-4">
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
                                    <input id="rol_id" class="form-control" type="text" v-model="data.rol_id">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_id" class="form-control-label">Área</label>
                                    <input id="department_id" class="form-control" type="text" v-model="data.department_id">
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
                                    <input id="region_id" class="form-control" type="number" v-model="data.region_id">
                                </div>
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
            message: '',
            load: false,
            count: 0,
            url: '',
        }
    },
    computed: {
        OPEN: function(){
            let _this = this
            if(_this.method == 'PUT') {
                axios({url: '/users/'+ _this.id, method: 'GET' })
                .then((resp) => {
                    _this.data = resp.data.records
                })
                .catch((err) => {
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
        CLOSE: function(){
            this.$emit('close')
        },
        SEND: function(){
            let _this = this
            this.count++
            this.load = true

            let icon = 'error'
            let method = this.method == 'PUT' ? '/' + this.data.id : ''

            if(this.count == 1){
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
							icon = 'success'
							_this.message = resp.data.message
                            _this.CLOSE()
                            _this.showToast(icon, _this.message)
						} else {
                            _this.message = resp.data.message.split("(")[0]
                            _this.showToast(icon, _this.message)
						}
                        _this.load = false
                        _this.count = 0
					}).catch((err) => {
						_this.showToast(icon)
					})
				}, 1000)
            }
        }
    }
}
</script>
