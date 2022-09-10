<template>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :class="OPEN == true ? 'd-block show' : ''">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="d-flex align-items-start px-3 py-1">
                    <button type="button " class="btn-close text-dark" @click="CLOSE()">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body pt-4 pb-3 px-4 text-center">
                    <h1 class="display-4 text-danger mb-3"><i class="fas fa-trash"></i></h1>
                    <h4 class="text-muted">{{ '¿Estás seguro?' }}</h4>
                    <p class="text-muted mb-4">¿Realmente desea eliminar estos registros?<br> Este proceso no se puede deshacer.</p>
                    <div class="row justify-content-center">
                        <div class="col-4 mb-2">
                            <button @click="CLOSE()" type="button" class="btn btn-secondary btn-sm ms-auto mt-2 mb-0">
                                <i class="fas fa-times"></i>
                                <span class="ms-2">Cancelar</span>
                            </button>
                        </div>
                        <div class="col-4 mb-2">
                            <button @click="SEND_DATA()" type="submit" class="btn btn-danger btn-sm ms-auto mt-2 mb-0">
                                <i class="fas fa-spinner fa-spin" v-if="load"></i>
                                <i class="fas fa-trash" v-else></i>
                                <span class="ms-2">Eliminar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['open', 'id'],
    data(){
        return {
            icon: '',
            message: '',
            load: false,
            count: 0,
        }
    },
    computed: {
        OPEN: function(){
            return this.open
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
        SEND_DATA: function(){
            let _this = this
            _this.count++
            _this.load = true
            if(_this.count == 1){
                axios({url: '/countries/' + _this.id, method: 'DELETE' })
                .then((resp) => {
                    setTimeout(() => {
                        _this.load = false
                        _this.count = 0
                        _this.icon = resp.data.result ? 'success' : 'error'
						_this.message = resp.data.message
                        _this.CLOSE()
                        _this.showToast(_this.icon, _this.message)
                    }, 1000)
                }).catch((err) => {
                    setTimeout(() => {
                        _this.count = 0
                        _this.load = false
                        _this.icon = 'error'
                        _this.showToast(_this.icon)
                        _this.CLOSE()
                    }, 750)
                })
            }
        }
    }
}
</script>
