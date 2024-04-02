<template lang="">
    <div>
        <div class="content-center p-5" style="background-color: #f5f7fa">
            <div class="row">
                <div class="col-3">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <h1>Mis Favoritos</h1>
                        <hr>
                        <div style="display: flex; align-items: center">
                            <i style="font-size: 1.5rem;" class="feather icon-trash-2"></i><a @click="eliminarTodo" style="padding-left: 25px; text-align: left" href="#" data-toggle="modal" data-target="#defaultSize" type="button"><strong> Borrar datos de <br> mis favoritos</strong></a> 
                        </div>
                        
                    </div>
                </div>
                <div class="col-9">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <div class="content-header row">
                        </div>
                        <div class="content-body">
                            <!-- email app overlay -->
                            <div class="app-content-overlay"></div>
                            <div class="email-app-area">
                                <!-- Email list Area -->
                                <div class="email-app-list-wrapper">
                                    <div class="email-app-list">
                                        <div class="email-action">
                                            <!-- action right start here -->
                                            <div class="action-right d-flex flex-grow-1 align-items-center justify-content-around">
                                                <!-- search bar  -->
                                                <div class="email-fixed-search flex-grow-1">
                                                    <div class="sidebar-toggle d-block d-lg-none">
                                                        <i class="feather icon-menu"></i>
                                                    </div>
                                                    <fieldset style="padding-right: 13px; padding-left: 9px;" class="form-group position-relative has-icon-left m-0">
                                                        <input @input="handleChange" style="border-radius: 50px" type="text" class="form-control" id="email-search" placeholder="Filtrar mis favoritos...">
                                                        <div class="form-control-position">
                                                            <i class="feather icon-search"></i>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            
                                            </div>
                                        </div>
                                        <!-- / action right -->
                                        <br><br>
                                        <!-- email user list start -->
                                        <div class="email-user-list list-group" style="background-color: white;padding: 12px;border-radius: 20px;margin: 10px;box-shadow: 0px -1px 17px 0px #bfbcbf; margin-bottom: 40px">
                                            <h4 style="margin: 20px;padding-bottom: 16px;border-bottom: 2px solid #dbd9d9;">Lista de Favoritos</h4>
                                            <ul class="users-list-wrapper media-list">
                                                <div v-if="loading" style="height: 400px">
                                                    <Skeleton></Skeleton>
                                                </div>
                                                <li v-for="(item2, index2) in datos" :key="index2" class="media mail-read" style="border-bottom: 1px solid #dbdbdb;">
                                                    <div class="user-action">
                                                        <div class="checkbox-con ">
                                                            <div class="custom-control custom-checkbox" style="display: flex; justify-content: center; align-items: center;">
                                                                <input @change="agregarValores()" type="checkbox" class="custom-control-input checkbox-eliminar-2" :value="item2._id.$oid" :id="'checkboxsmallmf'+index2">
                                                                <label class="custom-control-label" :for="'checkboxsmallmf'+index2">{{ item2.hora }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pr-50" style="margin-left: 4%">
                                                        <div class="avatar" style="height: 40px; width: 40px; border-radius: 0px">
                                                            <img style="border-radius: 0px" src="app-assets/images/portrait/small/star.png" alt="avtar img holder">
                                                        </div>
                                                    </div>
                                                    <div class="media-body" style="margin-left: 10px">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <div class="user-details">
                                                                    <div class="mail-items">
                                                                        <span class="list-group-item-text text-truncate"><strong>{{ item2.titulo }}</strong></span>
                                                                    </div>
                                                                </div>
                                                                <div class="mail-message">
                                                                    <p class="list-group-item-text truncate mb-0">
                                                                        ir a: <router-link style="color: #009c9f;" :to="'/'+item2.ruta">{{ item2.ruta }}</router-link> 
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Skeleton from './skeleton/skeletonSmall.vue';
import * as usuarioService from "../services/usuario";
import Swal from 'sweetalert2';


export default {
    components: {
        Skeleton
    },
    data() {
        return {
            datos: {},
            loading: true,
            inputValue: "todo",
            checkboxValues: []
        };
    },
    mounted() {
        this.BuscarFavoritos();
        this.verificarLogin();
        document.title = 'Favoritos - BiblioPED';
    },
    methods: {
        async verificarLogin(){
            var navigate = this.$router;
            await usuarioService.verificarLogin().then(respuesta => {
                if(respuesta.data == 0){
                    navigate.push({ name: 'paginaBusqueda'})
                }
            });
        },
        BuscarFavoritos: async function () {
            this.loading = true;
            try {
                await usuarioService.buscarFavoritos(this.inputValue).then(respuesta => {
                    this.datos = respuesta.data;
                    this.loading = false;
                });
            } catch (error) {
                console.log(error);
            }
        },
        handleChange(event) {
            if (event.target.value == "") {
                this.inputValue = "todo"
            } else {
                this.inputValue = event.target.value;
            }
            this.BuscarFavoritos();
        },
        eliminarTodo(){
            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    if( this.checkboxValues.length == 0){
                        this.eliminarTodoOK();
                    }else{
                        this.eliminarVariosOK();
                    }
                }
            })
        },
        async eliminarTodoOK(){
            this.tipo_borrado = "todo";

            var data = {
                "tipo_borrado": this.tipo_borrado,
                "ids_eliminar": []
            }

            await usuarioService.eliminarFavoritos(data).then(respuesta => {
                var respuesta = respuesta.data;
                toastr.success(respuesta);
                setTimeout(()=>{
                    this.checkboxValues = [];
                    const checkboxesMarcados = $('.checkbox-eliminar-2:checked');
                    checkboxesMarcados.prop('checked', false);
                    this.BuscarFavoritos();
                }, 1000)
            });
        },
        agregarValores() {
            const checkboxesMarcados = document.querySelectorAll('.checkbox-eliminar-2:checked');
            this.checkboxValues = Array.from(checkboxesMarcados).map(checkbox => checkbox.value);
        },
        async eliminarVariosOK(){
            this.tipo_borrado = "varios";

            var data = {
                "tipo_borrado": this.tipo_borrado,
                "ids_eliminar": this.checkboxValues
            }

            await usuarioService.eliminarFavoritos(data).then(respuesta => {
                var respuesta = respuesta.data;
                toastr.success(respuesta);
                setTimeout(()=>{
                    this.checkboxValues = [];
                    const checkboxesMarcados = $('.checkbox-eliminar-2:checked');
                    checkboxesMarcados.prop('checked', false);
                    this.BuscarFavoritos();
                }, 1000)
            });
        }
    }
}
</script>
<style lang="">
    
</style>