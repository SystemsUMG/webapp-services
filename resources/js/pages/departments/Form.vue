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
                        <p class="text-uppercase text-sm">Información del Departamento</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nombre del Departamento</label>
                                    <input id="name" class="form-control" type="text" v-model="data.name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Descripción</label>
                                    <input id="description" class="form-control" type="text" v-model="data.description">
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
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
                description: '',
            },
            load: false,
            count: 0,
            url: '',
        }
    },
    computed: {
        OPEN: function() {
            let _this = this
            if(_this.method == 'PUT') {
                axios({url: '/departments/' + _this.id, method: 'GET' })
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
					axios({url: '/departments' + method, method: 'POST', data: form })
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
