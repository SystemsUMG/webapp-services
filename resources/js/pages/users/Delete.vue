<template>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" :class="OPEN == true ? 'd-block show' : ''">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="don-close-modal" @click="CLOSE()">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body pt-4 pb-3 px-4 text-center">
                    <h1 class="display-4 text-danger mb-3"><i class="far fa-times-circle"></i></h1>
                    <h2 class="text-muted">{{ 'Estas seguro?' }}</h2>
                    <p class="text-muted mb-4">¿Realmente desea eliminar estos registros?<br> Este proceso no se puede deshacer.</p>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button @click="CLOSE()" type="button" class="btn btn-dark text-white py-2 w-100 rounded-0 btn-sm d-flex justify-content-center align-items-center">
                                <i class="fas fa-times"></i>
                                <h6 class="mb-0 ml-2 btn-text">Cancelar</h6>
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button @click="SEND_DATA()" class="btn btn-danger text-white py-2 w-100 rounded-0 btn-sm d-flex justify-content-center align-items-center">
                                <i class="fas fa-spinner fa-spin" v-if="load"></i>
                                <i class="fas fa-trash" v-else></i>
                                <h6 class="mb-0 ml-2 btn-text">Eliminar</h6>
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
            let icon = 'error'
            let _this = this
            _this.count++
            _this.load = true
            if(_this.count == 1){
                axios({url: '/users/' + _this.id, method: 'DELETE' })
                .then((resp) => {
                    setTimeout(() => {
                        _this.load = false
                        _this.count = 0
                        icon = 'success'
						_this.message = resp.data.message
                        _this.CLOSE()
                        _this.showToast(icon, _this.message)
                    }, 1000)
                }).catch((err) => {
                    setTimeout(() => {
                        _this.count = 0
                        _this.load = false
                    }, 750)
                })
            }
        }
    }
}
</script>
