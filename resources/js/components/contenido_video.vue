<template lang="">
    <div>
        <div id="colores" class="colores">
          <div id="coloresesconder" @click="escondermostrar">
            <i class="fas fa-angle-double-left" style="color: #7e7f81;"></i>
          </div>
          <div class="color" id="color1" @click="seleccionarcolor(1)"></div>
          <div class="color" id="color2" @click="seleccionarcolor(2)"></div>
          <div class="color" id="color3" @click="seleccionarcolor(3)"></div>
          <div class="color" id="color4" @click="seleccionarcolor(4)"></div>
          <div class="color" id="color5" @click="seleccionarcolor(5)"></div>
        </div>
        <div class="app-content container center-layout mt-2" style="max-width: 80%;">
            <div class="content-overlay"></div>
            <div class="content-wrapper" style="padding: 0.8rem">
                
                <div class="content-body">
                    <!-- Search form-->
                    <section id="search-website" class="card overflow-hidden">
                        <div class="card-header">
                            <h4 class="card-title">Contenido encontrado</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li data-toggle="tooltip" data-placement="top" title="Retroceder"><a @click="goBack"><i class="fa-2x fas fa-arrow-left"></i></a></li>
                                    <li data-toggle="tooltip" data-placement="top" title="Compartir"  v-if="sessionData.tipo_registro == 'docente'"><a type="button"  data-toggle="modal" data-target="#modalCompartir"><i class="fa-2x fas fa-share-alt"></i></a></li>
                                    <li data-toggle="tooltip" data-placement="top" title="Crear Foro" v-if="sessionData.tipo_registro == 'docente'"><a type="button"  data-toggle="modal" data-target="#modalForo"><i class="fa-2x fas fa-comments"></i></a></li>
                                    <li data-toggle="tooltip" data-placement="top" title="Marcar como favorito"><a @click="agregarFavorito"><i :class="favorito == true ? 'fas fa-star fa-2x' : 'fa-2x far fa-star'" :style="favorito ? 'color: #009c9f' : 'color: #404e67'"></i></a></li>
                                    <li data-toggle="tooltip" data-placement="top" title="Maximizar"><a data-action="expand"><i class="fa-2x fas fa-compress"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div id="search-results" class="card-body">
                                <div style="width: 100%;">
                                    <Skeleton v-if="loading"></Skeleton>
                                </div>
                                <br>
                                <br>
                                <h2>{{datos.titulo}}</h2>
                                <video :key="'video'+index" style="width: 100%; left: 24%; width: 50%; position: relative;" height="390" controls>
                                    <source :src="'/videos/'+rutaVideo" type="video/mp4">
                                </video>
                                <hr>
                                <div id="content" v-html="contenido_html"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="guardar_seleccion" id="guardar_seleccion" style="opacity: 0; z-index: 50; width: 100%; height: 100%; background-color: #000000d4; position: fixed; top: 0;">
            <div style="position: absolute; right: 132px; bottom: 154px; text-align: center">
                <h2 style="font-weight: bold; color: white">Para guardar la selección <br> haga click en el icono de "Guardar"</h2>
                <img class="imagen_flecha" src="/img/flecha.png" alt="">
            </div>
        </div>
        <button @click="guardarSeleccion" style="position: fixed; right: 20px; top: 84%; z-index: 100;" type="button" class="btn btn-float btn-float-lg btn-outline-primary btn-round">
            <i class="fa fa-save"></i>
        </button>

        <div class="modal fade text-left" id="modalCompartir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #1976d2; color: white;">
                        <h4 class="modal-title" id="myModalLabel17">Selecciona los estudiantes con los que deseas compartir este contenido</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <fieldset class="form-group position-relative has-icon-left">
                                    <select v-model="gradoSelect" name="grado" class="form-control">
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
                                    <select v-model="grupoSelect" name="grupo" class="form-control">
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
                                    <select v-model="jornadaSelect" name="jornada" class="form-control">
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
                                <button type="button" @click="filtrarEstudiantes(1)" class="btn btn-success"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="estudiantes_filtrados" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all" /></th>
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
                    <div class="modal-footer">
                        <button type="button" @click="compartirContenido" class="btn btn-outline-primary"><i class="fas fa-share"></i> Compartir</button>
                        <button type="button" @click="vaciarArray('#modalCompartir')" class="btn grey btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="modalForo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #1976d2; color: white;">
                        <h4 class="modal-title" id="myModalLabel17">Crear Foro</h4>
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
                                            <select v-model="gradoSelect" name="grado" class="form-control">
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
                                            <select v-model="grupoSelect" name="grupo" class="form-control">
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
                                            <select v-model="jornadaSelect" name="jornada" class="form-control">
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
                                                <th><input type="checkbox" id="select-all-2" /></th>
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
                        <button type="button" @click="crearForo" class="btn btn-outline-primary"><i class="fas fa-share"></i> Crear Foro</button>
                        <button type="button" @click="vaciarArray('#modalForo')" class="btn grey btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as busquedaService from "../services/busqueda";
import Skeleton from './skeleton/skeleton.vue';
import * as usuarioService from "../services/usuario";
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    props: ['ruta_video'],
    components: {
        Skeleton,
        QuillEditor
    },
    data() {
        return {
            id: 0,
            tipo: '',
            datos: {},
            loading: false,
            favorito: '',
            sessionData: {
                tipo_registro: null
            },
            gradoSelect: "",
            grupoSelect: "",
            jornadaSelect: "",
            tituloForo: "",
            descripcionForo: "",
            estudiantesFiltrados: [],
            arrayEstudiantesCompartir: [],
            table: null,
            escondido: false,
            tipoMarcador: 1,
            subrayados: [],
            apunteContenido: null,
            contenido_html: "",
            rutaVideo: ""
        };
    },
    mounted() {
        this.id = this.$route.params.id;
        this.tipo = this.$route.params.tipo;
        this.rutaVideo = this.$route.params.ruta_video;
        this.BuscarContenido();
        this.getSessionData();

        var content = document.getElementById('content');

        content.addEventListener('mouseup', () => {
            var selection = window.getSelection();
            if (selection.toString().length > 0) {
                var clase = '';
                switch (this.tipoMarcador) {
                    case 1:
                        clase = 'highlight1';
                        break;
                    case 2:
                        clase = 'highlight2';
                        break;
                    case 3:
                        clase = 'highlight3';
                        break;
                    case 4:
                        clase = 'highlight4';
                        break;
                    case 5:
                        clase = 'highlight5';
                        break;
                }

                var range = selection.getRangeAt(0);
                var clonedContents = range.cloneContents();
               
                if (this.containsLineBreak(clonedContents)) {
                    toastr.error("<i class='fas fa-exclamation-triangle'></i> Por favor subraye párrafo a párrafo.");
                    return;
                }

                var span = document.createElement('span');
                span.className = clase;

                span.appendChild(clonedContents);

                this.subrayados.push({
                    texto: span.textContent,
                    clase: clase
                });

                if(this.subrayados.length == 1){
                    this.mostrarGuardar();
                }

                range.deleteContents();
                range.insertNode(span);
            }
        });
    },
    methods: {
        containsLineBreak(node) {
            for (var i = 0; i < node.childNodes.length; i++) {
                var child = node.childNodes[i];
                if (child.nodeType === 1) { // Elemento
                    if (this.containsLineBreak(child)) {
                        return true;
                    }
                } else if (child.nodeType === 3) { // Texto
                    if (child.nodeValue.includes('\n')) {
                        return true;
                    }
                }
            }
            return false;
        },
        goBack() {
            this.$router.go(-1);
        },
        mostrarGuardar(){
            document.getElementById("guardar_seleccion").style.display = "block";
            setTimeout(()=>{
                document.getElementById("guardar_seleccion").style.opacity = 1;
            }, 100)

            setTimeout(()=>{
                document.getElementById("guardar_seleccion").style.opacity = 0;
                setTimeout(()=>{
                    document.getElementById("guardar_seleccion").style.display = "none";
                }, 1300)
            }, 3000)
        },
        BuscarContenido: async function () {
            this.loading = true;
            try {
                await busquedaService.busquedaContenido(this.id, this.tipo).then(respuesta => {
                    this.datos = respuesta.data.datos[0];
                    document.title =  this.datos.titulo;
                    this.contenido_html = this.datos.cont_documento;
                    this.loading = false;
                    this.verificarFavorito();
                });
            } catch (error) {
                console.log(error);
            }
        },
        async verificarFavorito(){
            await usuarioService.verificar_favorito(this.id).then(respuesta => {
                this.favorito = respuesta.data;
            });
        },  
        async agregarFavorito(){
            if(this.favorito == false){
                const datos = {
                    id: this.datos.id,
                    titulo: this.datos.titulo,
                    ruta: 'contenido/'+this.id+'/'+this.tipo
                };

                await usuarioService.agregar_favorito(datos).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    if(respuesta_ok[1] == 1){
                        toastr.success(respuesta_ok[0]);  
                        this.verificarFavorito();
                    }else{
                        toastr.error(respuesta_ok[0]);
                    }
                });
            }else{
                await usuarioService.eliminar_favorito(this.datos.id).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    toastr.success(respuesta_ok);  
                    this.verificarFavorito(); 
                });
            }
        },
        async getSessionData() {
            await usuarioService.getSessionData().then(respuesta => {
                this.sessionData = respuesta.data;
            });
        },
        async filtrarEstudiantes(tipo) {
            if(this.gradoSelect != "" && this.grupoSelect != "" && this.jornadaSelect != ""){
                await usuarioService.filtrarEstudiantes(this.gradoSelect, this.grupoSelect, this.jornadaSelect).then(respuesta => {
                    this.estudiantesFiltrados = respuesta.data;
                    if(this.estudiantesFiltrados.length == 0){
                        toastr.warning("¡No hay estudiantes para los filtros seleccionados!");
                    }else{
                        if(tipo == 1){
                            $('#estudiantes_filtrados').DataTable().clear().draw();
                            $('#estudiantes_filtrados').DataTable().destroy();
                            setTimeout(() => {
                                this.dataTablesA("#estudiantes_filtrados", "#select-all");
                            }, 200);
                        }else{
                            $('#estudiantes_filtrados_foro').DataTable().clear().draw();
                            $('#estudiantes_filtrados_foro').DataTable().destroy();
                            setTimeout(() => {
                                this.dataTablesA("#estudiantes_filtrados_foro", "#select-all-2");
                            }, 200);
                        }
                    }
                });
            }else{
                toastr.warning("¡Todos los campos son obligatorios!");
            }  
        },
        vaciarArray(id){
            $(id).modal('hide');
            this.estudiantesFiltrados = [];
            this.gradoSelect = "";
            this.grupoSelect = "";
            this.jornadaSelect = "";
            this.tituloForo = "";
            this.descripcionForo = "";
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
        async compartirContenido(){
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

            var data = {
                ids: this.arrayEstudiantesCompartir,
                titulo: this.datos.titulo,
                ruta: 'contenido/'+this.id+'/'+this.tipo
            }

            var tabla = this.table;

            if(this.arrayEstudiantesCompartir.length > 0) {
                await usuarioService.compartirContenido(data).then(respuesta => {
                    this.vaciarArray('#modalCompartir');
                    toastr.success(respuesta.data);
                    setTimeout(()=>{
                        tabla.rows().deselect();
                    }, 300)
                });
            }else{
                toastr.warning("¡Debe seleccionar al menos un estudiante!");
            }
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

            var data = {
                ids: this.arrayEstudiantesCompartir,
                id_contenido: this.datos.id,
                tipo_contenido: this.tipo,
                titulo: this.tituloForo,
                descripcion: this.descripcionForo,
                ruta: 'contenido/'+this.id+'/'+this.tipo
            }

            var tabla = this.table;

            if(this.arrayEstudiantesCompartir.length > 0 && this.tituloForo != "" && this.descripcionForo != "") {
                await usuarioService.crearForo(data).then(respuesta => {
                    this.vaciarArray('#modalForo');
                    toastr.success(respuesta.data);
                    setTimeout(()=>{
                        tabla.rows().deselect();
                    }, 300)
                });
            }else{
                toastr.warning("¡Debe seleccionar al menos un estudiante!");
            }
        },
        escondermostrar(){
            var div = document.getElementById("colores");
            if(this.escondido){
                div.style.right = "-2px";
                this.escondido = false;
            }else{
                div.style.right = "-101px"
                this.escondido = true;
            }
        },
        seleccionarcolor(index_p){
            this.tipoMarcador = index_p;
            var div = document.getElementById("content");

            switch (this.tipoMarcador) {
                case 1:
                    div.style.cursor = "url('data:image/png;base64,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'), auto";
                    break;
                case 2:
                    div.style.cursor = "url('data:image/png;base64,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'), auto";
                    break;
                case 3:
                    div.style.cursor = "url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAgoSURBVHja3NpbjCRVHcfx7/9UdVf1bWb6NssuQkBAFxIgSFhEg7uQqAEM6IsRHmADASFRbkYMicQHlQiGmxAWEB/AW2JMjESDESK3ByQgGzAiAiGwsC7Mzjoz293VXZdz/j5092zvsCwDzM4MVNLpTPqcTn36f+p3/l09oqp8HA4fgBN+VGBndBtzvdvnjvjUP7NCCd9ZFMWi9GxCajMODRpc8trP+cXbf0NEDthJqSpXN87kpk9czu54O+/1UY+/cCEGgEr5HBr5ixnLP4TKBrXuI1eRPmSssZFCBY5dv8arlJ8yNrvBWctHadn1IccddR0bTp2JZQJvLGBsbe2asBS+LHC+Ojep6khdhvEK1LzS6oWkXTMdTe++MtndpjA5jr9ugsKa6pGl6th9QSHc4edyrx9VWPtyFM++8HDnX9uAS1ZbtXyA9kPPoMr9+YnyRqL0QoyBMI+fCXnEVEzt0DiZ48w3fsrW9quEYeHuOO7lVfWOA3nRv/+lVQiQYkDc7V0RTc3uYraHbSf0koTAVtjWed2d8r8f62OF16mN1TJjhCAIbheRe1dLZQxA5mz/oa7djboPJq0IG/UoRDni9rSevft2tto35djyYTQadT8IgkxENAzDi0TkztWA6UNwZDisKInNnoviLvmeD1Gk587dpc/rW+YYby1JlpLL52k0Gn4YhhYgCILLgEtXGtOHaEamGRZLrMmOSpyDTpevt7foH9zz5tNmDW6wLWVZRn4PJhMRgiDYstIBYABKLk/J5Sm6HGvtGDjHZvmV/l6fM0f76xCRvXbXLMvI5XILMXcDF68Uxgd40UwB4GEoOp97is/yeGmHnCRH0Gl3cOIQZK8N0lpLPp+nXq/7U1NTWZqmfhAE9yRJ4qnqXcudZj7Ad8I/Dcoj9Mie6Ni098mkHoaNwPm+L7OzszLaB41WJggCJicn/enp6SyOYz8Igi1xHB+vqpctJ8YAxGTEZESkKLptwgabulFEL47NxMSElkolRARjzDuaxSGm2WwO04wwDC8VkbuXc5kZgJAcITkKg2cj5imnekoURcRxbOr1uisWi/0J74IZBkAQBBmgYRheIiJ3LRfGvNsLIvJ3Vf1cFEVYa02j0XhPTBAEQ4wdYL4pIjcuB8bs70UReVJVv9jpdHDO7YURkcVgCILgu8D5Bxpj3muAiDzsnPt2u92exyz2mhmJ5vuAiw4kxixmkIjc4Zzb1Gq1yLLMNJtNNz4+rvvD5PN5Jicn/VKpZI0xhGF4r4jcdqAwZrEDReQxVf1Cp9MhjmNTrVZ1bGxMh0ts4VLLsgzf96nVat5IZS4/UBjzfgaLyBOqummYZtVqVSuVynxlhtfOQky9Pt9oDjG3LjXGvN8Jg8qcFkURSZKYarWqo2m2EGOtHQ2AIeYKEbl5KTHmg0wSkUdV9fROp0Oapu9Is4XHgjQbYq4SkZuWCmM+6EQReURVN0ZRhHPO1Ov1RaXZgkbzahH54VJgzIeZLCKPO+eObrVaWGtNs9l0wwAYYhZeM8PebCTNvr8Um6b5sJ+EiLyoql/qdDokSWJqtZpWKhVGA2BhZTzPo16ve8VicX7TFJEbPgzGLMX6FJGHVPXLwzSr1WpuFLNwmVlr94W5RkR+8kExZqlSQ0T+6pw7Y1+YfbUz1tr5fWYkAL4nItcP3nFlIAPMX1T1jNGuuVwu6/56s+E3zXw+P8RcC1yfObtykBHMF0c3zXK5jDFmn8vMOUchDDG1gt813ayX9sDj2hOKh92J6y26MksOGTaaqnpwu92eSpLENJtNN9oBDKtjEDJn+U+0gyMrB/OVo07z1zcPt48e/APdXDv7spl06kllcdeMf6C6URH5r6qeGEXRs8aYZq1WcwCtVkuMMTjncCivJG9z5ZqzuOWgzSAeHGI9u7PHzM5tSM7/LMJvgPNWpCIjmDeBs0ajuVwuq4iQ83xeSnZwQf1UbjnkGrA56O4GG+M1HWGjhEsdqnoucOuKQgaYp1X1nCGmXq9ruVxm1nY4rnQoN669CLozkE4DDrIEUkuhWaJYL6hLHShXADevKGSAeUBVvzqCcVkBji+vZzJ3ECS79pyKAE4hdYSTRQkngiyLLcBV+8MsC2SA+aOqntnpdHBxZsxkxZkikPRAzMLBoAqZUmwWvXA8n9l+Za4CtqwoZIB5ENXD3+junDksnTDf2nWyMjcHgXnnr2Mi/cogUlpX8gvVILOpc6pcCjy6ohAAK/paV9IN1+08vXvi3HqZ2TWNi1PEN6jTfiX2mtCvTKER+oVq3rnUOZSNCzHLDknFUXXFV9a5yucJOwkptN9ooalFcoN7zKqA9qsi/QzQTCnU+xibOTvAPDLcMZcdIoATx5zpbkX1JC/vpVlqaW1vOU0t4gkMHPPLTfp/Y5VCLfDD8Ryuj9kE3LIikD0gAeR5VL/m5T2yxJrW9rbTzEJucMNcdR4jg0KpVYr1wCtUAw81GPFeXVHIyPFnlPP6GGdab7ad66Yq3vDMda8gEATUg9CRmOh3vazzs9UCAfgtyme8vLE2c2Zue0ezKFXx98aICBhDt9NhZtcMXdv6dZfdrCYIwFaUk03OOMC03+pq2tlTGRlEcq/bZXZ2ljRJzhfMA2bQLq4mCMA/UDYYX5yCab/V07SbqfgCYuhFEbMzM6RJcoGI/FJGWvzVBhliTja+KGCi6URtYunFEXNzcyRxvFlE7l/4vWY1QgCe6S8zQa2a9s5ea25m9t9x3LtARO7b172z1QoBeBplk/HkJax8I4vtMaD3v9vPefJx+cez/w8AfLlxo56LZs8AAAAASUVORK5CYII='), auto";
                    break;
                case 4:
                    div.style.cursor = "url('data:image/png;base64,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'), auto";
                    break;
                case 5:
                    div.style.cursor =  "url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAPNSURBVHjajJRbbJRFFMd/Z77L7na33UKphXJpBayCGJSgUTEQCV4IKmqiFjQkxERJjPpojOEFkGiiT4hRYsIlRvFFDMQXYoJCWkAuAWIt1XBrQNjtlsqW3e7ut98cH7atbBH1JJPJJGd+OfP/nzPy67w66pJJJre0YoMARcCRmRLa9brv0Bb54ON90tiMfLoWGpv5rzBVJwGMqSWf36OXe9vl5Zd2ydL2mQQlKJf5P+FW450EQ/lDnPnlLvP+DmTpiqTu3HJYTh9+kMam34lEhvNcCK5D/iKIM1zJWKAYn2L+J3pOzDYbv0SWrsC+sQzT8cP43OTW/WGidr4Opi6JQLQ8RKpmCscmrsa3BQStMHQEaIxDUOzQnpPzzIZtyLKV6JonMT0n6GttI3Whd6IxqWMgD4D0NucGONQynTfnr6Wh0I8QVoAhuNaYO6Ket5XfTs6XdzchT6/CvrUcc/oYmfpJXLlwnmg0iog0AQdA7jch6YSrtJZS1AcZBFsBWjAO5tXsmbML9J3NmBfXYN9+FnPq4FjYiDDTgKPApFu7nLr2UXj7nbuKy9th/RrMqc5RWKQaVilCzFRHOTCukBl3oxk3tI2T8RPJ54e+3fz9+a++YLC+iYFLvXiRCGYMTMXg2hLxAjOONC/5ueT4DaJ2DNB1KV/to25qy1MDjc17dx/vwvd94p47IvUwTHBswPSr/Wy993U+mbdx5oT85QOgtdVA1crm+zTEIk8M4u7rzJZwUGKmIreKwWjI9P5+ts99jXUPf8bk6+fwbXEWSCdQVz0pAmotosoE11ncV7I/dl4r4QhEjUFtmRn9GXbOWcX6BZ/Tkj1DTTBIKA7AHGA/ELtp9LTiPPWOszhdsh0HswGeWNr+zPD13at4b9F2pmTPkgiyhOLeeHEuSocYvcf8k/UKOs4xC6+UwoPpi2n2zlnJhke305w9RyK4Vg37O+6zZdNubtVPFrFtYXbRjuTjR55p2sTU4iUaNEuZm2EioKLbSkPOh7cEKhALNeiatGRhMZU7fvFUD8aP4PnDPlbn7kRZLUaz5t++orJAbTBQMNHgkcuZ0onu7j58z8VzDTpCFb4BVoy67GoZlxDPAZcQR8ujy1UQFIsMJeL+onRfrqv7dB+RqEO8xgfhOxHaRSrPFgE3FgZEtAieUqMFImGZ0BbwRIiG4GhY6VM0WxP3Hkqnc0dtqG2Nt8X3JJP+c8YI1iqqYMQgLzy2DhOPEZs9m0J3FwO5AqExCELMljhX08Yf0WnEwvzw6MqsQk5f8Tx3w/jx0SFgVFMbCn8NAMAPlMwNl2WeAAAAAElFTkSuQmCC'), auto";
                    break;
            }

            var colores =  document.getElementsByClassName("color");
            for (let index = 0; index < colores.length; index++) {
                const element = colores[index];
                element.style.border = "none";
            }
            
            document.getElementById("color"+index_p).style.border = "3px solid #5e5d5d";
        },
        async guardarSeleccion(){
            var data = {
                id_contenido: this.datos.id,
                tipo_contenido: this.tipo,
                titulo: this.datos.titulo,
                data: document.getElementById("content").innerHTML,
                ruta: 'contenido/'+this.id+'/'+this.tipo
            }

            if(this.subrayados.length > 0) {
                await usuarioService.guardarSeleccion(data).then(respuesta => {
                    const respuesta_ok = respuesta.data;
                    if (respuesta_ok.estado === 1) {
                        toastr.success('<i class="fas fa-check"></i> '+respuesta_ok.mensaje);
                    } else {
                        toastr.error('<i class="fas fa-exclamation-triangle"></i> '+respuesta_ok.mensaje);
                    }
                });
            }else{
                toastr.warning("¡No hay apuntes que guardar!");
            }
        }
    }
}
</script>
<style>

    .list-inline li {
        margin-left: 5px;
        margin-right: 5px;
    }
    
    #content{
        cursor: url('data:image/png;base64,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'), auto;
    }
    
    .colores{
        width: 100px;
        height: 370px;
        position: fixed;
        border-radius: 15px 0px 0px 15px;
        right: -2px;
        top: 23%;
        background-color: #fff;
        box-shadow: 0 10px 40px 0 rgb(109 109 109 / 28%), 0 2px 9px 0 rgb(107 107 107 / 32%);
        transition: right .5s linear;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    #coloresesconder {
        cursor: pointer;
        content: "";
        position: absolute;
        left: -20px;
        top: 37%;
        width: 20px;
        height: 56px;
        background-color: #fff;
        border-radius: 5px 0px 0px 5px;
        box-shadow: -6px 0px 10px rgb(109 109 109 / 28%);       
        display: flex;
        justify-content: center;
        align-items: center; 
    }

    .color {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin: 12px;
        cursor: pointer;
    }

    #color1{
        background-color: #ffdd21;
        border: 3px solid #5e5d5d;
    }

    #color2{
        background-color: #59ddfb;
        border: none;
    }

    #color3{
        background-color: #fe5196;
        border: none;
    }

    #color4{
        background-color: #bcf220;
        border: none;
    }

    #color5{
        background-image: url('/img/borrador_logo.png');
        border: none;
        background-repeat: no-repeat;
        background-size: 80% 80%;
        background-position: center;
    }

    .highlight1 {
        background-color: #ffdd21;
    }

    .highlight2 {
        background-color: #59ddfb;
    }

    .highlight3 {
        background-color: #fe5196;
        color: #fff;
    }

    .highlight4 {
        background-color: #bcf220;
    }

    .highlight5 {
        background-color: #ffff;
        color: #404e67;
    }

    #guardar_seleccion{
        display: none;
        transition: opacity 1.3s linear;
    }

    .imagen_flecha {
        position: absolute;
        height: 73px;
        right: -40px;
        top: 83px;
        animation: animacion-img 1.5s infinite alternate;
    }

    @keyframes animacion-img {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.1);
        }
    }
</style>