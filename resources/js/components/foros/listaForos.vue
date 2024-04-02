<template lang="">
    <div style="background-color: #f5f7fa">
        <div class="app-content container center-layout mt-2" style="max-width: 90%;">
            <div class="content-overlay"></div>
            <div class="content-wrapper" style="padding: 0.8rem">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">Foros</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Inicio</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/foros">Foros</a>
                                    </li>
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                    <!-- Search form-->
                    <section id="search-website" class="card overflow-hidden">
                        <div class="card-header">
                            <h4 class="card-title">Lista de foros a los que perteneces</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a @click="goBack"><i class="fas fa-arrow-left"></i></a></li>
                                    <li><a data-action="expand"><i class="fas fa-compress"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show" style="min-height: 450px">
                            <div id="search-results" class="card-body">
                                <div v-if="loading" style="width: 100%; position: absolute; height: 450px">
                                    <SkeletonTabla :mensaje="'Obteniendo datos...'"></SkeletonTabla>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table id="lista_foros" class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Docente</th>
                                                    <th>Título</th>
                                                    <th>Comentarios</th>
                                                    <th>Miembro desde</th>
                                                    <th>Link</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in foros" :key="index">
                                                    <td style="text-align: center"><i :style="item.estado == 'Abierto' ? 'color: green' : 'color: red'" class="fas fa-circle"></i></td>
                                                    <td><img style="width: 30px; height: 30px" :src="item.profesor.imagen"> <strong>{{ item.profesor.nombre }}</strong> </td>
                                                    <td>{{ item.titulo }}</td>
                                                    <td>{{ item.comentarios.length }} Comentarios</td>
                                                    <td>{{ item.fecha }} - {{ item.horas }}</td>
                                                    <td><a data-toggle="tooltip" data-placement="top" title="Ir al Foro" class="btn btn-success" :href="'foro/'+item._id.$oid"><i class="fas fa-external-link-square-alt"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import SkeletonTabla from '../skeleton/skeletonTabla.vue';
import * as usuarioService from "../../services/usuario";
import * as forosService from "../../services/foros";

export default {
    components: {
        SkeletonTabla
    },
    created() {
        document.title = 'Mis foros - BiblioPED';
    },
    data() {
        return {
            foros: [],
            loading: true
        };
    },
    mounted() {
        this.verificarLogin();
        this.getSessionData();
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        async verificarLogin(){
            var navigate = this.$router;
            await usuarioService.verificarLogin().then(respuesta => {
                if(respuesta.data == 0){
                    navigate.push({ name: 'paginaBusqueda'})
                }
            });
        },
        async getSessionData() {
            await usuarioService.getSessionData().then(respuesta => {
                this.sessionData = respuesta.data;
                this.ListarForos();
            });
        },
        ListarForos: async function () {
            this.loading = true;
            await forosService.foros(this.sessionData.tipo_registro).then(respuesta => {
                this.foros = respuesta.data;
                setTimeout(()=>{
                    this.dataTables();
                }, 500)
            });
        },
        dataTables() {
            $("#lista_foros").DataTable({
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
            });
            setTimeout(()=>{
                this.loading = false;
            }, 300)
        },
    }
}
</script>
<style lang="">
    
</style>