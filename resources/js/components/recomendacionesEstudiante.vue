<template lang="">
    <div>
        <div class="content-center p-5" style="background-color: #f5f7fa">
            <div class="row">
                <div class="col-3">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <h1>Recomendaciones</h1>
                        <hr>
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
                                      
                                        <!-- email user list start -->
                                        <div class="email-user-list list-group" style="background-color: white;padding: 12px;border-radius: 20px;margin: 10px;box-shadow: 0px -1px 17px 0px #bfbcbf; margin-bottom: 40px; min-height: 550px">
                                            <h4 style="margin: 20px;padding-bottom: 16px;border-bottom: 2px solid #dbd9d9; color: #009c9f; font-weight: bold">Lista de Recomendaciones</h4>
                                            <div v-if="loading" style="width: 100%; position: absolute; height: 600px">
                                                <SkeletonTabla :mensaje="'Obteniendo datos...'"></SkeletonTabla>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="recomendacion-datatable" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 200px">Profesor</th>
                                                            <th>Tema</th>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Enlace</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in datos" :key="index">
                                                            <td><img style="width: 30px; height: 30px" :src="item.profesor.imagen"> {{ item.profesor.nombre }}</td>
                                                            <td>{{ item.titulo }}</td>
                                                            <td>{{ item.fecha }}</td>
                                                            <td>{{ item.horas }}</td>
                                                            <td><a  data-toggle="tooltip" data-placement="top" title="Abrir Contenido" type="button" class="btn btn-success" style="color: white"><router-link style="color: white; font-weight: bold" :to="'/'+item.ruta">ir <i class="fas fa-external-link-alt"></i></router-link></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
import SkeletonTabla from './skeleton/skeletonTabla.vue';


export default {
    components: {
        SkeletonTabla
    },
    data() {
        return {
            datos: [],
            inputValue: "todo",
            tipo_borrado: "",
            loading: true
        };
    },
    mounted() {
        this.obtenerRecomendacionesEstudiante();
        this.verificarLogin();
        document.title = 'Recomendaciones - BiblioPED';
    },
    methods: {
        async verificarLogin(){
            this.loading = true;
            var navigate = this.$router;
            await usuarioService.verificarLogin().then(respuesta => {
                if(respuesta.data == 0){
                    navigate.push({ name: 'paginaBusqueda'})
                }
            });
        },
        async obtenerRecomendacionesEstudiante() {
            await usuarioService.recomendacionesEstudiante(this.inputValue).then(respuesta => {
                this.datos = respuesta.data;
                setTimeout(() => {
                    this.dataTables();
                }, 1000);
            });
        },
        handleChange(event) {
            if (event.target.value == "") {
                this.inputValue = "todo"
            } else {
                this.inputValue = event.target.value;
            }
            this.obtenerRecomendacionesEstudiante();
        },
        dataTables() {
            $("#recomendacion-datatable").DataTable({
                paging: true,
                pageLength: 10,
                ordering: false,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                'columnDefs': [{
                    "orderable": false,
                }]
            });

            setTimeout(() => {
               this.loading  = false;
            }, 400);
        },
    }
}
</script>
<style lang="">
    
</style>