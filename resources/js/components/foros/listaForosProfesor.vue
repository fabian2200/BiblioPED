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
                                    <li class="breadcrumb-item"><a href="/foros-profesor">Foros</a>
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
                            <h4 class="card-title">Lista de foros que ha creado</h4>
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
                                <br>
                                <button @click="tipoRegistroEditar = 1" data-toggle="modal" data-target="#modalForoCrear" style="font-size: 20px" class="btn btn-success">Crear foro <i class="fas fa-plus"></i></button>
                                <hr>
                                <div style="margin-top: 30px">
                                    <div class="table-responsive">
                                        <table id="lista_foros" class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px"></th>
                                                    <th>Docente</th>
                                                    <th style="width: 400px">Título</th>
                                                    <th style="width: 100px; text-align: center"># Participantes</th>
                                                    <th style="width: 100px; text-align: center"># Comentarios</th>
                                                    <th style="width: 100px; text-align: center">Creado</th>
                                                    <th style="width: 150px; text-align: center">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in foros" :key="index">
                                                    <td style="text-align: center"><i :style="item.estado == 'Abierto' ? 'color: green' : 'color: red'" class="fas fa-circle"></i></td>
                                                    <td><img style="width: 30px; height: 30px" :src="item.profesor.imagen"> <strong>{{ item.profesor.nombre }}</strong> </td>
                                                    <td>{{ item.titulo }}</td>
                                                    <td style="text-align: center"><a @click="estudiantesUnForo = item.lista_estudiantes" style="color: #00b5b8; text-decoration: underline" data-toggle="modal" data-target="#modalEstudiantesForo" type="button">{{ item.estudiantes.length }} Participantes</a></td>
                                                    <td style="text-align: center">{{ item.comentarios.length }} Comentarios</td>
                                                    <td style="text-align: center">{{ item.fecha }}</td>
                                                    <td style="text-align: center">
                                                        <a data-toggle="tooltip" data-placement="top" title="Ir al Foro" style="padding: 0.35rem 0.5rem !important;" class="btn btn-success" :href="'foro/'+item._id.$oid"><i class="fas fa-external-link-square-alt"></i></a>
                                                        <a @click="idForoEditar = item._id.$oid" style="margin-left: 10px; text-align: center; padding: 0.35rem 0.5rem !important;"  data-toggle="modal" data-target="#modalForoEditar" class="btn btn-warning" type="button"><i data-toggle="tooltip" data-placement="top" title="Agregar Personas" style="color: white" class="fas fa-user-plus"></i></a>
                                                        <a data-toggle="tooltip" data-placement="top" title="Cambiar Estado" @click="cambiarEstado(item)" style="margin-left: 10px; text-align: center; padding: 0.35rem 0.5rem !important;"  class="btn btn-danger" type="button"><i style="color: white" class="fas fa-sync-alt"></i></a>
                                                        <a @click="abrirEditarInfoForo(item)" data-toggle="tooltip" data-placement="top" title="Editar Foro" style="margin-left: 10px; text-align: center; padding: 0.35rem 0.5rem !important;"  class="btn btn-primary" type="button"><i style="color: white" class="fas fa-edit"></i></a>
                                                    </td>
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
        <div class="modal fade text-left" id="modalForoEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #1976d2; color: white;">
                        <h4 class="modal-title" id="myModalLabel17">Agregar personas a foro</h4>
                    </div>
                    <div class="modal-body">
                        <h3 style="color: #ff425c;">Selecciona los estudiantes que deseas agregar a este foro</h3>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <fieldset class="form-group position-relative has-icon-left">
                                    <select v-model="gradoSelectEdit" name="grado" class="form-control">
                                        <option value="">Seleccione un grado</option>
                                        <option value="1">1º</option>
                                        <option value="2">2º</option>
                                        <option value="3">3º</option>
                                        <option value="4">4º</option>
                                        <option value="5">5º</option>
                                        <option value="6">6º</option>
                                        <option value="7">7º</option>
                                        <option value="8">8º</option>
                                        <option value="9">9º</option>
                                        <option value="10">10º</option>
                                        <option value="11">11º</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-4">
                                <fieldset class="form-group position-relative has-icon-left">
                                    <select v-model="grupoSelectEdit" name="grupo" class="form-control">
                                        <option value="">Seleccione un grupo</option>
                                        <option value="Grupo 1">Grupo 1</option>
                                        <option value="Grupo 2">Grupo 2</option>
                                        <option value="Grupo 3">Grupo 3</option>
                                        <option value="Grupo 4">Grupo 4</option>
                                        <option value="Grupo 5">Grupo 5</option>
                                        <option value="Grupo 6">Grupo 6</option>
                                        <option value="Grupo 7">Grupo 7</option>
                                        <option value="Grupo 8">Grupo 8</option>
                                        <option value="Grupo 9">Grupo 9</option>
                                        <option value="Grupo 10">Grupo 10</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-3" style="padding: 0">
                                <fieldset class="form-group position-relative has-icon-left">
                                    <select v-model="jornadaSelectEdit" name="jornada" class="form-control">
                                        <option value="">Jornada</option>
                                        <option value="Mañana">Mañana</option>
                                        <option value="Tarde">Tarde</option>
                                        <option value="Continua">Continua</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="fas fa-sun"></i>
                                    </div>
                                </fieldset>

                                <input type="hidden" name="tipo_registro" value="estudiante">
                            </div>
                            <div class="col-1" style="display: flex; height: 80%;">
                                <button type="button" @click="filtrarEstudiantes(2)" class="btn btn-success"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="estudiantes_filtrados_foro" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all-foro" /></th>
                                        <th>Nombre</th>
                                        <th>Grupo</th>
                                        <th>Grado</th>
                                        <th>Jornada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in estudiantesFiltradosForo" :key="index">
                                        <td></td>
                                        <td>{{ item.nombre }}</td>
                                        <td>{{ item.grupo }}</td>
                                        <td>{{ item.grado }}</td>
                                        <td>{{ item.jornada }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="editarForo" class="btn btn-outline-primary"><i class="fas fa-user-plus"></i> Agregar Estudiantes</button>
                        <button type="button" @click="vaciarArray('#modalForo')" class="btn grey btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade text-left" id="modalEstudiantesForo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #1976d2; color: white;">
                        <h4 class="modal-title" id="myModalLabel17">Lista de estudiantes que pertenecen a este foro</h4>
                    </div>
                    <div class="modal-body">
                        <br>
                        <div class="table-responsive">
                            <table id="estudiantes_filtrados_foro" class="table">
                                <thead>
                                    <tr style="background-color: #16d39a94">
                                        <th>Nombre</th>
                                        <th>Grupo</th>
                                        <th>Grado</th>
                                        <th>Jornada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in estudiantesUnForo" :key="index">
                                        <td><img style="width: 30px; height: 30px" :src="item.imagen"> <strong>{{ item.nombre }}</strong></td>
                                        <td>{{ item.grupo }}</td>
                                        <td>{{ item.grado }} º</td>
                                        <td>{{ item.jornada }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn red btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade text-left" id="modalForoCrear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #1976d2; color: white;">
                        <h4 class="modal-title" id="myModalLabel17">Crear/Editar Foro</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 style="color: #ff425c;"><strong>1. </strong>Información general del foro</h3>
                                <hr>
                                <div class="row" style="margin: 0px">
                                    <label for="pregunta"><strong>Título de tu foro</strong></label>
                                    <input type="text" v-model="tituloForo" class="form-control" name="titulo_foro" id="titulo_foro">
                                </div>
                                <br>
                                <div class="row" style="margin: 0px">
                                    <label for="pregunta"><strong>Describe el tema de tu foto</strong></label>
                                    <QuillEditor  style="height: 300px; width: 100%" theme="snow" toolbar="full" />
                                </div>
                            </div>  
                            <div class="col-lg-6">
                                <h3 style="color: #ff425c;"><strong>2. </strong>Selecciona los estudiantes para los cuales estará dirigido este foro</h3>
                                <hr>
                                <br>
                                <div class="row">
                                    <div class="col-4">
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <select :disabled="tipoRegistroEditar == 2" v-model="gradoSelect" name="grado" class="form-control">
                                                <option value="">Seleccione un grado</option>
                                                <option value="1">1º</option>
                                                <option value="2">2º</option>
                                                <option value="3">3º</option>
                                                <option value="4">4º</option>
                                                <option value="5">5º</option>
                                                <option value="6">6º</option>
                                                <option value="7">7º</option>
                                                <option value="8">8º</option>
                                                <option value="9">9º</option>
                                                <option value="10">10º</option>
                                                <option value="11">11º</option>
                                            </select>
                                            <div class="form-control-position">
                                                <i class="fas fa-graduation-cap"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-4">
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <select :disabled="tipoRegistroEditar == 2" v-model="grupoSelect" name="grupo" class="form-control">
                                                <option value="">Seleccione un grupo</option>
                                                <option value="Grupo 1">Grupo 1</option>
                                                <option value="Grupo 2">Grupo 2</option>
                                                <option value="Grupo 3">Grupo 3</option>
                                                <option value="Grupo 4">Grupo 4</option>
                                                <option value="Grupo 5">Grupo 5</option>
                                                <option value="Grupo 6">Grupo 6</option>
                                                <option value="Grupo 7">Grupo 7</option>
                                                <option value="Grupo 8">Grupo 8</option>
                                                <option value="Grupo 9">Grupo 9</option>
                                                <option value="Grupo 10">Grupo 10</option>
                                            </select>
                                            <div class="form-control-position">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-3" style="padding: 0">
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <select :disabled="tipoRegistroEditar == 2" v-model="jornadaSelect" name="jornada" class="form-control">
                                                <option value="">Jornada</option>
                                                <option value="Mañana">Mañana</option>
                                                <option value="Tarde">Tarde</option>
                                                <option value="Continua">Continua</option>
                                            </select>
                                            <div class="form-control-position">
                                                <i class="fas fa-sun"></i>
                                            </div>
                                        </fieldset>

                                        <input type="hidden" name="tipo_registro" value="estudiante">
                                    </div>
                                    <div class="col-1" style="display: flex; height: 80%;">
                                        <button :disabled="tipoRegistroEditar == 2" type="button" @click="filtrarEstudiantes(1)" class="btn btn-success"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="estudiantes_filtrados_foro_crear" class="table">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all-foro-crear" /></th>
                                                <th>Nombre</th>
                                                <th>Grupo</th>
                                                <th>Grado</th>
                                                <th>Jornada</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in estudiantesFiltrados" :key="index">
                                                <td></td>
                                                <td>{{ item.nombre }}</td>
                                                <td>{{ item.grupo }}</td>
                                                <td>{{ item.grado }}</td>
                                                <td>{{ item.jornada }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> 
                            </div>    
                        </div>                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="crearForo" class="btn btn-outline-primary"><i class="fas fa-save"></i> Guardar Información Foro</button>
                        <button type="button" @click="vaciarArray2('#modalForoCrear')" class="btn grey btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import * as usuarioService from "../../services/usuario";
import * as forosService from "../../services/foros";
import Swal from 'sweetalert2';
import SkeletonTabla from '../skeleton/skeletonTabla.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    components: {
        SkeletonTabla,
        QuillEditor
    },
    created() {
        document.title = 'Foros';
    },
    data() {
        return {
            foros: [],
            gradoSelectEdit: '',
            grupoSelectEdit: '',
            jornadaSelectEdit: '',
            estudiantesFiltradosForo: [],
            table: null,
            arrayEstudiantesCompartirForo: [],
            idForoEditar: "",
            loading: true,
            estudiantesUnForo: [],
            gradoSelect: "",
            grupoSelect: "",
            jornadaSelect: "",
            tituloForo: "",
            descripcionForo: "", 
            estudiantesFiltrados: [],
            arrayEstudiantesCompartir: [],
            idForoEditarInfo: "",
            tipoRegistroEditar: 1,
            foroEditar: {
                estudiantes: null,
                id_contenido: null,
                tipo_contenido: null,
                titulo: null,
                descripcion: null,
                ruta: null
            }
        };
    },
    mounted() {
        this.verificarLogin();
        this.getSessionData();
        document.title = 'Mis foros - BiblioPED';
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
                $('#lista_foros').DataTable().destroy();
                setTimeout(()=>{
                    this.dataTables();
                }, 800)
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
        async filtrarEstudiantes(tipo) {
            if(tipo == 2){
                if(this.gradoSelectEdit != "" && this.grupoSelectEdit != "" && this.jornadaSelectEdit != ""){
                    await usuarioService.filtrarEstudiantes(this.gradoSelectEdit, this.grupoSelectEdit, this.jornadaSelectEdit).then(respuesta => {
                        this.estudiantesFiltradosForo = respuesta.data;
                        if(this.estudiantesFiltradosForo.length == 0){
                            toastr.warning("¡No hay estudiantes para los filtros seleccionados!");
                        }else{
                            $('#estudiantes_filtrados_foro').DataTable().clear().draw();
                            $('#estudiantes_filtrados_foro').DataTable().destroy();
                            setTimeout(() => {
                                this.dataTablesA("#estudiantes_filtrados_foro", "#select-all-foro");
                            }, 200);
                        }
                    });
                }else{
                    toastr.warning("¡Todos los campos son obligatorios!");
                }  
            }else{
                if(this.gradoSelect != "" && this.grupoSelect != "" && this.jornadaSelect != ""){
                    await usuarioService.filtrarEstudiantes(this.gradoSelect, this.grupoSelect, this.jornadaSelect).then(respuesta => {
                        this.estudiantesFiltrados = respuesta.data;
                        if(this.estudiantesFiltrados.length == 0){
                            toastr.warning("¡No hay estudiantes para los filtros seleccionados!");
                        }else{
                            $('#estudiantes_filtrados_foro_crear').DataTable().clear().draw();
                            $('#estudiantes_filtrados_foro_crear').DataTable().destroy();
                            setTimeout(() => {
                                this.dataTablesA("#estudiantes_filtrados_foro_crear", "#select-all-foro-crear");
                            }, 200);
                        }
                    });
                }else{
                    toastr.warning("¡Todos los campos son obligatorios!");
                }  
            }
        },
        dataTablesA(id_tabla, id_check) {
            this.table = $(id_tabla).DataTable({
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
                columnDefs: [
                    {
                        orderable: false,
                        className: 'select-checkbox', 
                        targets: 0,
                    }
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child',
                },
                order: [[1, 'asc']]
            });

            var tabla = this.table;

            $(id_check).on('click', function () {
                if (this.checked) {
                    tabla.rows().select();
                } else {
                    tabla.rows().deselect();
                }
            });
        },
        vaciarArray(){
            $("#modalForoEditar").modal('hide');
            this.estudiantesFiltradosForo = [];
            this.gradoSelectEdit = "";
            this.grupoSelectEdit = "";
            this.jornadaSelectEdit = "";
        },
        vaciarArray2(){
            $("#modalForoCrear").modal('hide');
            this.estudiantesFiltrados = [];
            this.gradoSelect = "";
            this.grupoSelect = "";
            this.jornadaSelect = "";
            this.tituloForo = "";
            this.descripcionForo = "";
            document.querySelector(".ql-editor").innerHTML = "";
        },
        async editarForo(){
            this.arrayEstudiantesCompartirForo = [];

            if(this.table != null){
                var selectedData = this.table.rows({ selected: true }).data().toArray();
                for (let index = 0; index < selectedData.length; index++) {
                    const element = selectedData[index];
                    var registro = this.estudiantesFiltradosForo.find((item) => item.nombre == element[1] && item.grupo == element[2] && item.grado == element[3] && item.jornada == element[4]);
                    if(registro != null) {
                        this.arrayEstudiantesCompartirForo.push({
                            id: registro._id.$oid,
                            nombre: registro.nombre
                        });
                    }
                }
            }

            var data = {
                ids: this.arrayEstudiantesCompartirForo,
                id_foro: this.idForoEditar
            }

            var tabla = this.table;

            if(this.arrayEstudiantesCompartirForo.length > 0) {
                await forosService.editarForo(data).then(respuesta => {
                    toastr.success(respuesta.data);
                    setTimeout(()=>{
                        tabla.rows().deselect();
                        this.vaciarArray('#modalForoEditar');
                        this.ListarForos();
                        this.loading = false;
                    }, 300)
                });
            }else{
                toastr.warning("¡Debe seleccionar al menos un estudiante!");
            }
        },
        async cambiarEstado(foro){
            Swal.fire({
                title: '¿Desea cambiar el estado del foro?',
                text: "Actualmente se encuentra en estado ("+foro.estado+")",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, cambiar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = foro._id.$oid;
                    var estado = foro.estado;
                    foro.estado = foro.estado == "Cerrado" ? "Abierto" : "Cerrado";
                    this.cambiar(id, estado);
                }
            })
            
            
        },
        async cambiar(id, estado){
            await forosService.cambiarEstadoForo(id, estado).then(respuesta => {
                toastr.success(respuesta.data);
            });
        },
        async crearForo(){
            this.arrayEstudiantesCompartir = [];

            if(this.table != null){
                var selectedData = this.table.rows({ selected: true }).data().toArray();
                for (let index = 0; index < selectedData.length; index++) {
                    const element = selectedData[index];
                    var registro = this.estudiantesFiltrados.find((item) => item.nombre == element[1] && item.grupo == element[2] && item.grado == element[3] && item.jornada == element[4]);
                    if(registro != null) {
                        this.arrayEstudiantesCompartir.push(registro._id.$oid);
                    }
                }
            }

            this.descripcionForo = document.querySelector(".ql-editor").innerHTML;

            if(this.tipoRegistroEditar == 1){
                var data = {
                    ids: this.arrayEstudiantesCompartir,
                    id_contenido: null,
                    tipo_contenido: null,
                    titulo: this.tituloForo,
                    descripcion: this.descripcionForo,
                    ruta: null
                }

                var tabla = this.table;

                if(this.arrayEstudiantesCompartir.length > 0 && this.tituloForo != "" && this.descripcionForo != "") {
                    await usuarioService.crearForo(data).then(respuesta => {
                        this.vaciarArray2();
                        toastr.success(respuesta.data);
                        setTimeout(()=>{
                            this.ListarForos();
                            tabla.rows().deselect();
                        }, 300)
                    });
                }else{
                    toastr.warning("¡Todos los datos son obligatorios!");
                }
            }else{

                this.foroEditar.estudiantes = this.arrayEstudiantesCompartir;
                this.foroEditar.titulo = this.tituloForo;
                this.foroEditar.descripcion = this.descripcionForo;

                var data2 = {
                    "info_foro": this.foroEditar,
                    "id_foro_editar": this.idForoEditarInfo
                };

                var tabla = this.table;

                if(this.arrayEstudiantesCompartir.length > 0 && this.tituloForo != "" && this.descripcionForo != "") {
                    await forosService.editarInfoForo(data2).then(respuesta => {
                        this.vaciarArray2();
                        this.ListarForos();
                        toastr.success(respuesta.data);
                        setTimeout(()=>{
                            tabla.rows().deselect();
                        }, 300)
                    });
                }else{
                    toastr.warning("¡Todos los datos son obligatorios!");
                }
            }
        },
        abrirEditarInfoForo(foro){
            this.idForoEditarInfo = foro._id.$oid;
            this.tipoRegistroEditar = 2;
            $("#modalForoCrear").modal('show');
            this.tituloForo = foro.titulo;
            document.querySelector(".ql-editor").innerHTML = foro.descripcion;

            this.estudiantesFiltrados = foro.lista_estudiantes;

            this.foroEditar.id_contenido = foro.id_contenido;
            this.foroEditar.ruta = foro.ruta;
            this.foroEditar.tipo_contenido = foro.tipo_contenido;

            $('#estudiantes_filtrados_foro_crear').DataTable().clear().draw();
            $('#estudiantes_filtrados_foro_crear').DataTable().destroy();

            setTimeout(()=>{
                this.dataTablesA("#estudiantes_filtrados_foro_crear", "#select-all-foro-crear");
                setTimeout(()=>{
                    var tabla = this.table;
                    tabla.rows().select();
                }, 200)
            }, 500)
        },
    }
}
</script>
<style>
    #toast-container > .toast {
        background-image: none !important;
    }

    .tooltip {
        background-color: #333;
        color: white;
        padding: 5px;
        border-radius: 4px;
    }
</style>