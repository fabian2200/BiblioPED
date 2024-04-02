<template lang="">
    <div>
        <div class="content-center p-5" style="background-color: #f5f7fa">
            <div class="row">
                <div class="col-3">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <h1>Recomendaciones</h1>
                        <hr>
                        <div style="display: flex; align-items: center">
                            <i style="font-size: 1.5rem;" class="feather icon-trash-2"></i><a style="padding-left: 25px" href="#" data-toggle="modal" data-target="#defaultSize" type="button"><strong> Borrar Recomendaciones</strong></a> 
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
                                                        <input @input="handleChange" style="border-radius: 50px" type="text" class="form-control" id="email-search" placeholder="Filtrar busquedas...">
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
                                        <div id="accordionWrap1" role="tablist" aria-multiselectable="true"  v-for="(item, index) in datos" :key="index" style="background-color: white;padding: 12px;border-radius: 20px;margin: 10px;box-shadow: 0px -1px 17px 0px #bfbcbf; margin-bottom: 40px">
                                            <div class="card accordion collapse-icon accordion-icon-rotate" style="background-color: transparent; box-shadow: none; margin-bottom: 0">
                                                <div id="heading11" class="card-header primary" data-toggle="collapse" :href="'#accordion'+index" aria-expanded="true" :aria-controls="'accordion'+index">
                                                    <a class="card-title lead" href="#">{{ item.titulo }} <router-link style="color: #009c9f;" :to="'/'+item.ruta">ir <i class="fas fa-external-link-alt"></i></router-link> - {{ item.fecha }}</a>
                                                </div>
                                                <div :id="'accordion'+index" role="tabpanel" data-parent="#accordionWrap1" aria-labelledby="heading11" class="collapse show">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <h5 style="margin-left: 20px"><strong>Recomendaste este contenido a los siguientes estudiantes: </strong></h5>
                                                            <ul class="users-list-wrapper media-list">
                                                                <li v-for="(item2, index2) in item.alumnos_recomendados" :key="index2" class="media mail-read" style="border-bottom: 1px solid #dbdbdb;">    
                                                                    <div class="pr-50">
                                                                        <div style="width: 40px; height: 40px">
                                                                            <img :src="item2.imagen" style="height: 100%; width: 100%">
                                                                        </div>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <div class="row">
                                                                            <div class="col-11">
                                                                                <div class="user-details">
                                                                                    <div class="mail-items">
                                                                                        <span style="text-transform: capitalize;" class="list-group-item-text text-truncate"><strong>{{ item2.nombre }}</strong></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mail-message">
                                                                                    <p class="list-group-item-text truncate mb-0">
                                                                                        <strong>Grado:  {{ item2.grado }}°</strong>
                                                                                    </p>
                                                                                    <p class="list-group-item-text truncate mb-0">
                                                                                        <strong>Grupo:  {{ item2.grupo }}°</strong> | <strong>Jornada: {{ item2.jornada }}</strong>
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as usuarioService from "../services/usuario";
export default {
    data() {
        return {
            datos: [],
            inputValue: "todo",
            tipo_borrado: ""
        };
    },
    mounted() {
        this.obtenerRecomendacionesDocente();
        this.verificarLogin();
        document.title = 'Recomendaciones - BiblioPED';
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
        async obtenerRecomendacionesDocente() {
            await usuarioService.recomendacionesDocente(this.inputValue).then(respuesta => {
                this.datos = respuesta.data;
            });
        },
        handleChange(event) {
            if (event.target.value == "") {
                this.inputValue = "todo"
            } else {
                this.inputValue = event.target.value;
            }
            this.obtenerRecomendacionesDocente();
        },
        async eliminar(){
            this.tipo_borrado = this.$refs.tipo_borrado.value;
            await usuarioService.eliminarRecomendaciones(this.tipo_borrado).then(respuesta => {
                var respuesta = respuesta.data;
                toastr.success("Se hán eliminado "+respuesta+ " recomendacion(es).");
                $('#defaultSize').modal('hide');
                setTimeout(()=>{
                    this.obtenerRecomendacionesDocente();
                }, 1000)
            });
        }
    }
}
</script>
<style lang="">
    
</style>