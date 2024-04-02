<template lang="">
    <div style="padding: 50px">
        <h1 style="color: #009c9f; font-weight: bold">Gestión de Contenido</h1>
        <hr>
        <section class="users-list-wrapper">
            <div class="users-list-filter px-1">
                <form>
                    <div class="row border border-light rounded py-2 mb-2">
                        <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                            <a href="/agregar-contenido" class="btn btn-block btn-primary glow">Agregar Contenido <i class="fas fa-plus-circle"></i></a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-5">
                            
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <label for="users-list-status">Tipo de multimedia</label>
                            <fieldset class="form-group">
                                <select v-model="filtro" class="form-control" id="users-list-status">
                                    <option value="todos">Todos</option>
                                    <option value="metafacto">Metafactos</option>
                                    <option value="video">Videos</option>
                                    <option value="normal">Contenido</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-1  d-flex align-items-center">
                            <button style="margin-top: 5px" @click="filtrarDatos" type="button" class="btn btn-block btn-warning glow"><i class="fas fa-search"></i></button>
                        </div>
                       
                    </div>
                </form>
            </div>
            <div class="users-list-table">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <!-- datatable start -->
                            <div class="table-responsive">
                                <table id="contenido_registrado_table" class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 400px">Tema</th>
                                            <th>Tipo Contenido</th>
                                            <th>Tipo Multimedia</th>
                                            <th>Asignatura</th>
                                            <th>Grado</th>
                                            <th style="text-align: center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in contenidosFiltrados" :key="index">
                                            <td>{{ item.tipo_contenido_registrado == 'Multimedia' ? item.tema : item.titulo }}</td>
                                            <td>{{ item.tipo_contenido_registrado }}</td>
                                            <td style="text-transform: capitalize">{{ item.tipo_multimedia }}</td>
                                            <td>{{ item.asignatura }}</td>
                                            <td>Grado {{ item.grado }}º</td>
                                            <td style="text-align: center">
                                                <a  @click="mensajeEliminar(item)" style="margin-left: 10px; text-align: center; padding: 0.35rem 0.5rem !important;"  data-toggle="modal" data-target="#modalEditarDocente" class="btn btn-danger" type="button"><i style="color: white" class="fas fa-trash"></i></a>
                                                <a  @click="editarContenido(item, true)" style="margin-left: 10px; text-align: center; padding: 0.35rem 0.5rem !important;"  data-toggle="modal" data-target="#modalEditarDocente" class="btn btn-warning" type="button"><i style="color: white" class="fas fa-edit"></i></a>
                                                <a  @click="editarContenido(item, false)" style="margin-left: 10px; text-align: center; padding: 0.35rem 0.5rem !important;"  data-toggle="modal" data-target="#modalEditarDocente" class="btn btn-success" type="button"><i style="color: white" class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- datatable ends -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>

import * as adminService from "../../services/admin";
import Swal from 'sweetalert2';

export default {
    components: {
       
    },
    data() {
        return {
           loading: false,
           contenidos: [],
           contenidosFiltrados: [],
           filtro: "todos",
           datosEditar: {},
        };
    },
    mounted() {
        this.listarContenido();
        document.title = 'Lista de contenido - BiblioPED';
    },
    methods: {
        dataTables() {
            $("#contenido_registrado_table").DataTable({
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
        },
        listarContenido: async function () {
            this.loading = true;
            try {
                await adminService.listarContenidoRegistrado().then(respuesta => {
                    this.contenidosFiltrados = respuesta.data;
                    this.contenidos = respuesta.data;
                    this.loading = false;
                    $('#contenido_registrado_table').DataTable().destroy();
                    setTimeout(() => {
                        this.dataTables();
                    }, 200);
                });
            } catch (error) {
                console.log(error);
            }
        },
        filtrarDatos(){
            if (this.filtro == 'todos') {
                this.contenidosFiltrados =  this.contenidos;
            } else {
                this.contenidosFiltrados = this.contenidos.filter(item => item.tipo_multimedia == this.filtro);
            }

            $('#contenido_registrado_table').DataTable().destroy();
            setTimeout(() => {
                this.dataTables();
            }, 200);
        },
        editarContenido(objetoParaEnviar, editableP){
            this.$router.push({
                name: 'editarContenido',
                params: {
                    objeto: JSON.stringify(objetoParaEnviar),
                    editable: editableP
                },
            });
        },
        mensajeEliminar(objetoParaEnviar){
            Swal.fire({
                title: '¿Desea eliminar este contenido?',
                text: "No puede revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                   this.eliminarContenido(objetoParaEnviar);
                }
            })
        },
        async eliminarContenido(objetoParaEnviar){
            var navigate = this.$router;
            this.loading = true;

            const formData = new FormData();
            formData.append('tipo_contenido', objetoParaEnviar.tipo_contenido);
            formData.append('tipo_multimedia', objetoParaEnviar.tipo_multimedia);
            formData.append('oid', objetoParaEnviar._id.$oid);

            try {
                await adminService.eliminarDatosContenido(formData).then(respuesta => {
                    const respuesta_ok = respuesta.data;
                    if (respuesta_ok.estado === 1) {
                        toastr.success(respuesta_ok.mensaje);
                    } else {
                        toastr.error(respuesta_ok.mensaje);
                    }

                    this.loading = false;
                    setTimeout(() => {
                        navigate.push({ name: 'listaContenido' })
                    }, 1000)
                });
            } catch (error) {
                console.log(error);
            }
        }
    },
};
</script>
<style lang="">
    
</style>