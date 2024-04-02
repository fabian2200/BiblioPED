<template lang="">
    <div>
        <div class="row" style="padding-top: 20px; background-image: url('/img/fondo_social.png'); background-size: 100% 780px; background-repeat-y: repeat;">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="app-content content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div id="user-profile">
                            <div v-if="item != null">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-1"></div>
                                    <div class="col-lg-8 col-sx-10">
                                        <section id="timeline" class="timeline-center timeline-wrapper">
                                            <h3 class="page-title text-center">Publicación Original</h3>
                                            <hr>
                                            <ul class="timeline">                                   
                                                <li class="timeline-item" style="border-radius: 20px; position: relative">
                                                    <div class="opciones_comentario">
                                                        <div class="btn-group mr-1 mb-1">
                                                        <button v-if="datosLogin._id.$oid == item.usuario._id.$oid" type="button" style="background-color: transparent; border-color: transparent; min-width: 18.5rem;" class="btn btn-dark dropdown-toggle menu_editar_eliminar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i style="font-size: 28px; color: #404e67" class="feather icon-more-horizontal"></i>
                                                        </button>
                                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 41px, 0px);">
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#modalEditarPublicacion" href="" @click.prevent="verModalEditar(item)"><i class="feather icon-edit-2"></i> Editar</a>
                                                            <a class="dropdown-item" @click="eliminarPostPreguntar(item._id.$oid)" href="#"><i class="feather icon-trash-2"></i> Eliminar</a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="timeline-card card border-grey border-lighten-2">
                                                        <div class="card-header" style="background-color: #bdedf3">
                                                            <div class="media">
                                                                <div class="media-left mr-1">
                                                                    <a href="#">
                                                                        <span class="avatar avatar-md avatar-busy"><img :src="'/'+item.usuario.imagen" alt="avatar"></span>
                                                                        <i></i>
                                                                    </a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <h4 class="card-title"><a class="encabezado_movil" href="#">{{ item.usuario.nombre }} - <strong v-if="item.usuario.tipo_registro == 'estudiante'" style="color: #7d7d7d">{{ item.usuario.grado }}° grado</strong><strong v-if="item.usuario.tipo_registro == 'docente'" style="color: #7d7d7d">Docente</strong></a></h4>
                                                                    <p class="card-subtitle text-muted mb-0 pt-1">
                                                                        <span v-if="item.editado" class="font-small-3">{{ item.fecha_formateada_edicion }} <strong>(editada)</strong></span>
                                                                        <span v-else class="font-small-3">{{ item.fecha_formateada }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-content">
                                                                <div class="card-body">
                                                                    <p class="card-text letra_publicacion" style="font-size: 20px;font-weight: bold;color: rgb(89, 87, 87);line-height: 24px;">{{ item.detalle }}</p>
                                                                    <img style="margin-bottom: 20px" v-if="item.imagen != ''" class="img-fluid" :src="'/imagenes_comunidad/'+item.imagen" alt="Timeline Image 1">
                                                                    <ul class="list-inline">
                                                                        <li @mouseover="mostrarDivMegusta(index)" @mouseout="ocultarDivMegusta(index)" v-if="!item.like" class="pr-1"><a href="" @click.prevent="meGustaPost(item._id.$oid)" class="" type="button"><span class="fa fa-thumbs-o-up"></span> ({{ item.likes.length }})</a></li>
                                                                        <li @mouseover="mostrarDivMegusta(index)" @mouseout="ocultarDivMegusta(index)" v-else class="pr-1"><a href="" @click.prevent="meGustaPost(item._id.$oid)" class="" type="button"><span class="fa fa-thumbs-up"></span> ({{ item.likes.length }}) Me gusta </a></li>
                                                                        <li class="pr-1"><a href="#" class=""><span class="fa fa-commenting-o"></span> ({{item.comentarios.length}}) Comentarios</a></li>
                                                                    </ul>
                                                                    <div class="miDivMegusta" :id="'divmegusta'+index">
                                                                        <p style="font-weight: bold" v-html="item.usuarios_likes"></p>
                                                                    </div>
                                                                </div>
                                                            </div>                     
                                                            <div class="card-footer px-0 py-0">
                                                                <div class="card-body" style="max-height: 400px; overflow-y: scroll;">
                                                                    <div v-for="(item2, index2) in item.comentarios" :key="index2">
                                                                        <div class="media media_box_movil" style="padding-left: 20px; margin-bottom: 15px">
                                                                            <div class="media-body">
                                                                                <div class="media" style="position: relative">
                                                                                    <div class="media-left mr-1">
                                                                                        <a href="#">
                                                                                            <span class="avatar avatar-online"><img :src="'/'+item2.usuario.imagen" alt="avatar"></span>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="burbuja">
                                                                                            <p class="text-bold-600 mb-0"><a href="#">{{ item2.usuario.nombre }}</a></p>
                                                                                            <p style="margin-bottom: 5px">{{ item2.comentarioTexto }}</p>
                                                                                        </div>
                                                                                        <button v-if="datosLogin._id.$oid == item2.usuario._id.$oid" type="button" style="background-color: transparent; border-color: transparent; min-width: 1.5rem;" class="btn btn-dark dropdown-toggle menu_editar_eliminar eliminarcomemntario" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            <i style="font-size: 18px; color: #404e67" class="feather icon-more-horizontal"></i>
                                                                                        </button>
                                                                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 41px, 0px);">
                                                                                            <a class="dropdown-item" href=""  data-toggle="modal" data-target="#modalEditarComentarioP" @click.prevent="verModalEditarComentario(item._id.$oid, item2, 2)"><i class="feather icon-edit-2"></i> Editar</a>
                                                                                            <a class="dropdown-item" type="button" @click="eliminarRespuestaComentarioPregunta(item._id.$oid, item2._id.$oid)"><i class="fas fa-trash-alt"></i> Eliminar</a>
                                                                                        </div>
                                                                                        <ul class="list-inline" style="margin-left: 20px">
                                                                                            <li class="pr-1"><a type="button" @click="likeComentario(item._id.$oid, item2._id.$oid)" class=""><span :class=" item2.like_usuario == 0 ?'fa fa-thumbs-o-up' : 'fa fa-thumbs-up'"></span> ({{item2.likes.length}} Me gusta)</a></li>
                                                                                            <li @click="setIdPublicacionRespuesta(item._id.$oid, item2)" class="pr-1"><a style="font-weight: bold; color: #009c9f; cursor: pointer" type="button" class=""> Responder </a></li>
                                                                                            <li class="pr-1"><strong> {{ item2.fechaFormateada }}</strong></li>
                                                                                            <li style="cursor: pointer" @click="verRespuestas('caja_respuestas_'+item2._id.$oid)" v-if="item2.respuestas_comentario.length > 0" class="pr-1"><strong> {{ item2.respuestas_comentario.length }} Respuesta(s)</strong></li>                                                                                            
                                                                                        </ul>
                                                                                        <ul v-if="item2.respuestas_comentario.length > 0" style="display: block" :id="'caja_respuestas_'+item2._id.$oid">
                                                                                            <div style="display: flex; margin-top: 10px" v-for="(item3, index3) in item2.respuestas_comentario" :key="index" class="media-body">
                                                                                                <div class="media-left mr-1">
                                                                                                    <a href="#">
                                                                                                        <span class="avatar avatar-online"><img :src="'/'+item3.usuario.imagen" alt="avatar"></span>
                                                                                                    </a>
                                                                                                </div>
                                                                                                <div class="media-body" style="display: flex">
                                                                                                    <div class="burbuja2">
                                                                                                        <p class="text-bold-600 mb-0"><a href="#">{{ item3.usuario.nombre }}</a></p>
                                                                                                        <p style="margin-bottom: 5px">{{ item3.comentarioTexto }}</p>
                                                                                                    </div>
                                                                                                    <div style="margin-left: 10px;display: flex; justify-content: center; align-items: center">
                                                                                                        
                                                                                                            <button v-if="datosLogin._id.$oid == item3.usuario._id.$oid" type="button" style="background-color: transparent; border-color: transparent; min-width: 1.5rem;" class="btn btn-dark dropdown-toggle menu_editar_eliminar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                                <i style="font-size: 18px; color: #404e67" class="feather icon-more-horizontal"></i>
                                                                                                            </button>
                                                                                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 41px, 0px);">
                                                                                                                <a class="dropdown-item" href=""  data-toggle="modal" data-target="#modalEditarComentarioP" @click.prevent="verModalEditarComentario(item._id.$oid, item3, 1)"><i class="feather icon-edit-2"></i> Editar</a>
                                                                                                                <button class="dropdown-item" @click="eliminarRespuestaPreguntar(item._id.$oid, item3._id.$oid)" href="#"><i class="feather icon-trash-2"></i> Eliminar</button>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                        
                                                                <div class="card-body" style="padding-top: 0px">
                                                                    <div class="alert alert-success" v-if="responderActivo">
                                                                        <p style="margin: 0px">Respondiendo comentario de <strong>{{comentarioResponder.usuario.nombre}}</strong> <strong @click="responderActivo = false" style="color: red; cursor: pointer">Cancelar<a href=""></a></strong></p>
                                                                    </div>
                                                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                                                        <input @click='setIdPublicacion(item._id.$oid, index)' :id="'inputComentario'+index" type="text" class="form-control" placeholder="Write comments...">
                                                                        <div style="top: 7px; left: 4px" class="form-control-position">
                                                                            <i @click="mostrarEmojis(index)" style="font-size: 1.6em; cursor: pointer" class="far fa-laugh-beam"></i>
                                                                        </div>
                                                                        <i @click="guardarComentario"  class="comentar fas fa-paper-plane"></i>
                                                                    </fieldset>
                                                                    <div :id="'EmojiPicker'+index" style="position: relative; top: -378px; right: -233px; display: none">
                                                                        <EmojiPicker 
                                                                            :disable-skin-tones="true"
                                                                            :native="true" 
                                                                            @select="onSelectEmoji"
                                                                            :disable-sticky-group-names="true"
                                                                            :hide-search="true"
                                                                            :hide-group-icons="false"
                                                                            :disabled-groups="['activities', 'travel_places', 'objects', 'flags']"
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </section>
                                    </div>   
                                    <div class="col-lg-2 col-xs-1"></div> 
                                </div> 
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-1"></div>
        </div>

        <div class="modal fade text-left" id="modalEditarPublicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" v-if="publicacionEditar != null">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="card-header" style="background-color: #a8dbc4; width: 100%">
                            <div class="media">
                                <div class="media-left mr-1">
                                    <a href="#">
                                        <span class="avatar avatar-md avatar-busy"><img :src="'/'+publicacionEditar.usuario.imagen" alt="avatar"></span>
                                        <i></i>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="card-title"><a href="#">{{ publicacionEditar.usuario.nombre }} - <strong v-if="publicacionEditar.usuario.tipo_registro == 'estudiante'" style="color: #7d7d7d">{{ publicacionEditar.usuario.grado }}° grado</strong><strong v-if="publicacionEditar.usuario.tipo_registro == 'docente'" style="color: #7d7d7d">Docente</strong></a></h4>
                                    <p class="card-subtitle text-muted mb-0 pt-1">
                                        <span class="font-small-3">{{ publicacionEditar.fecha_formateada }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button type="button"  @click="cerrarModalEditarPublicacion" class="close btn_cerar_modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 600px; overflow-y: auto; padding-bottom: 7px;">
                        <div class="card-content">
                            <div class="card-body">
                                <label for="detalleEditar"><strong>Detalles de la publicación</strong></label>
                                <textarea v-model="detallePublicacionEditar" id="detalleEditar" rows="6" class="form-control" style="font-size: 15px; font-weight: bold; color: rgb(89, 87, 87); line-height: 24px;"></textarea>
                                <br>
                                    <form style="min-height: 250px; display: flex; align-items: center; justify-content: center;" @click="openFileInputPublicacionEditar" action="#" class="dropzone dropzone-area" id="dpz-single-file">
                                        <input type="file" accept="image/*" ref="fileInputPublicacionEditar" style="display: none" @change="handleFileChangePublicacionEditar" />
                                        <div v-if="!selectedImageEditar" style="display: flex; align-items: center; justify-content: center; flex-direction: column; width: 70%; height: 200px; text-align: center">
                                            <img src="/img/upload_icon.png" width="90" height="75" alt="">
                                            <h6 style="color: #808080; margin-top: 10px"><strong>Se admite, JPG, PNG, Gif <br> tamaño máximo 2 MB</strong></h6>
                                        </div>
                                    </form>
                                    <div v-if="selectedImageEditar" style="z-index: 10; position: absolute; top: 46%; left: 14%; display: flex; align-items: center; justify-content: center; width: 70%; height: 200px; text-align: center">
                                        <img style="width: 80%; max-height: 100%;" :src="selectedImageEditar" alt="Imagen cargada" />
                                        <div class="btn_eliminar"><i @click="eliminarImagenPublicacionEditar" style="color: white" class="fas fa-trash fa-3x"></i></div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn grey btn-outline-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                                <button type="button" class="btn btn-outline-primary" @click="editarPublicacion"><i class="fa fa-save"></i> Publicar</button>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="modalEditarComentarioP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" v-if="comentarioSeleccionado != null">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="card-header" style="background-color: #a8dbc4; width: 100%">
                            <div class="media">
                                <div class="media-left mr-1">
                                    <a href="#">
                                        <span class="avatar avatar-md avatar-busy"><img :src="'/'+comentarioSeleccionado.usuario.imagen" alt="avatar"></span>
                                        <i></i>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="card-title"><a href="#">{{ comentarioSeleccionado.usuario.nombre }} - <strong v-if="comentarioSeleccionado.usuario.tipo_registro == 'estudiante'" style="color: #7d7d7d">{{ comentarioSeleccionado.usuario.grado }}° grado</strong><strong v-if="comentarioSeleccionado.usuario.tipo_registro == 'docente'" style="color: #7d7d7d">Docente</strong></a></h4>
                                    <p class="card-subtitle text-muted mb-0 pt-1">
                                        <span class="font-small-3">{{ comentarioSeleccionado.fecha }} {{ comentarioSeleccionado.horas }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="close btn_cerar_modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 600px; overflow-y: auto; padding-bottom: 7px;">
                        <div class="card-content">
                            <div class="card-body">
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <input v-model="comentarioSeleccionado.comentarioTexto" id="inputComentario001" type="text" class="form-control" placeholder="Write comments...">
                                    <div style="top: 7px; left: 4px" class="form-control-position">
                                        <i @click="mostrarEmojis('001')" style="font-size: 1.6em; cursor: pointer" class="far fa-laugh-beam"></i>
                                    </div>
                                    <i v-if="tipoeditarComentario==2" @click="guardarEdicionComentario" class="comentar fas fa-paper-plane"></i>
                                    <i v-if="tipoeditarComentario==1" @click="guardarEdicionRespuesta" class="comentar fas fa-paper-plane"></i>
                                </fieldset>
                                <div :id="'EmojiPicker001'" style="position: relative; top: 14px; right: 0px; display: none">
                                    <EmojiPicker 
                                        :disable-skin-tones="true"
                                        :native="true" 
                                        @select="onSelectEmoji"
                                        :disable-sticky-group-names="true"
                                        :hide-search="true"
                                        :hide-group-icons="false"
                                        :disabled-groups="['activities', 'travel_places', 'objects', 'flags']"
                                    />
                                </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as comunidadService from "../../services/comunidad";
import EmojiPicker from 'vue3-emoji-picker'
import 'vue3-emoji-picker/css'
import * as usuarioService from "../../services/usuario";
import Swal from 'sweetalert2';

export default {
    components: {
        EmojiPicker
    },
    data() {
        return {
            detallePublicacion: '',
            selectedImage: null,
            imageFile: null,
            pixelesDesplazados: 0,
            indexComentario: 0,
            selectedPosted: null,
            datosLogin: null,
            publiSeleccionada: null,
            indexpubliSeleccionada: null,
            publicacionEditar: null,
            detallePublicacionEditar: '',
            selectedImageEditar: null,
            imageFileEditar: null,
            intervalId: null,
            item: null,
            idParametro: null,
            responderActivo: false,
            comentarioSeleccionado: null,
            tipoeditarComentario: null,
            idPublicacionEditarComentario: null,
            comentarioDesdeModal: false,
            padreComentarioResponder: 0,
            comentarioResponder: null,
        }
    },
    mounted() {
        this.idParametro = this.$route.params.id;
        this.verificarLogin();
        window.addEventListener("scroll", this.actualizarPixelesDesplazados);
        this.misDatos();
        this.intervalId = setInterval(this.listarPublicaciones2, 60000);
    },
    beforeDestroy() {
        clearInterval(this.intervalId);
        window.removeEventListener("scroll", this.actualizarPixelesDesplazados);
    },
    methods: {
        misDatos: async function () {
            await usuarioService.misDatos().then(respuesta => {
                this.datosLogin = respuesta.data;
                this.listarPublicacionPorID();
            });
        },
        async verificarLogin(){
            var navigate = this.$router;
            await usuarioService.verificarLogin().then(respuesta => {
                if(respuesta.data == 0){
                    navigate.push({ name: 'paginaBusqueda'})
                }
            });
        }, 
        async listarPublicacionPorID() {
            await comunidadService.listarPublicacionPorID(this.idParametro).then(respuesta => {
                this.item = respuesta.data;
            });
        },
        onSelectEmoji(emoji) {
            var valorExistente = $("#inputComentario" + this.indexComentario).val();
            var nuevoValor = valorExistente + " " + emoji.i;
            $("#inputComentario" + this.indexComentario).val(nuevoValor);
        },
        mostrarEmojis(index) {
            this.indexComentario = index;
            var miDiv = $("#EmojiPicker" + index);
            if (miDiv.css("display") === "none") {
                miDiv.css("display", "block");
            } else {
                miDiv.css("display", "none");
            }
        },
        setIdPublicacion(id, index) {
            this.selectedPosted = id;
            this.indexComentario = index;
        },
        async guardarComentario() {
            if(this.responderActivo == false){
                var comentarioTexto = $("#inputComentario" + this.indexComentario).val();
                var datos = {
                    comentarioTexto: comentarioTexto,
                    idPost: this.selectedPosted
                }

                if (comentarioTexto != "") {
                    await comunidadService.registrarComentarioPost(datos).then(respuesta => {
                        var respuesta_ok = respuesta.data;
                        if (respuesta_ok[1] == 1) {
                            $("#inputComentario" + this.indexComentario).val("");
                            var miDiv = $("#EmojiPicker" + this.indexComentario);
                            if (miDiv.css("display") === "block") {
                                miDiv.css("display", "none");
                            }
                            toastr.success(respuesta_ok[0]);
                            this.listarPublicacionPorID();
                        } else {
                            toastr.error(respuesta_ok[0]);
                        }
                    });
                } else {
                    toastr.warning("¡No ha escrito nada en la caja de comentarios");
                }
            }else{
                var comentarioTexto = $("#inputComentario" + this.indexComentario).val();
                var datos = {
                    comentarioTexto: comentarioTexto,
                    idComentario: this.comentarioResponder._id.$oid,
                    idPublicacion: this.padreComentarioResponder
                }

                if (comentarioTexto != "") {
                    await comunidadService.registrarRespuestaComentarioPost(datos).then(respuesta => {
                        var respuesta_ok = respuesta.data;
                        if (respuesta_ok[1] == 1) {
                            $("#inputComentario" + this.indexComentario).val("");
                            var miDiv = $("#EmojiPicker" + this.indexComentario);
                            if (miDiv.css("display") === "block") {
                                miDiv.css("display", "none");
                            }
                            toastr.success(respuesta_ok[0]);
                            this.infoPost();
                            this.responderActivo = false;
                        } else {
                            toastr.error(respuesta_ok[0]);
                        }
                    });
                } else {
                    toastr.warning("¡No ha escrito nada en la caja de comentarios");
                }
            }
        },
        async eliminarRespuestaComentarioPregunta(id_publicacion, id_comentario) {
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
                    this.eliminarRespuestaComentario(id_publicacion, id_comentario);
                }
            })
        },
        async eliminarRespuestaComentario(id_publicacion, id_comentario) {
            await comunidadService.eliminarRespuestaComentario(id_publicacion, id_comentario).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if (respuesta_ok[1] == 1) {
                    toastr.success(respuesta_ok[0]);
                    this.listarPublicacionPorID();
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        verModalEditar(item){
            this.publicacionEditar = item;
            this.detallePublicacionEditar = item.detalle;

            if(item.imagen != "" ){
                this.selectedImageEditar = "/imagenes_comunidad/"+item.imagen;

                const rutaArchivo = item.imagen;

                fetch('/imagenes_comunidad/' + rutaArchivo)
                .then(response => response.blob())
                .then(blob => {
                    const archivo = new File([blob], item.imagen, { type: 'image/png' });
                    return archivo;
                })
                .then(archivo => {
                    this.imageFileEditar = archivo;
                })
                .catch(error => {
                    console.error(error);
                });

            }
        },
        openFileInputPublicacionEditar() {
            this.$refs.fileInputPublicacionEditar.click();
        },
        handleFileChangePublicacionEditar(event) {
            const file = event.target.files[0];
            this.imageFileEditar = event.target.files[0];
            if (file) {
                this.selectedImageEditar = URL.createObjectURL(file);
            }
        },
        eliminarImagenPublicacionEditar() {
            this.selectedImageEditar = null;
            this.imageFileEditar = null;
        },
        async editarPublicacion() {
            const formData = new FormData();
            formData.append('id_publicacion', this.publicacionEditar._id.$oid);
            formData.append('detalle', this.detallePublicacionEditar);
            formData.append('imagen', this.imageFileEditar);

            if (this.detallePublicacionEditar != "") {
                const response = await comunidadService.editarPublicacion(formData);
                const respuesta_ok = response.data;
                if (respuesta_ok[1] === 1) {
                    toastr.success(respuesta_ok[0]);
                    this.listarPublicacionPorID();
                } else {
                    toastr.error(respuesta_ok[0]);
                }

                this.detallePublicacion = '';
                this.selectedImage = null;
                this.imageFile = null;
                $("#modalEditarPublicacion").modal('hide');
            } else {
                toastr.error('¡El campo detalle de la publicación es obligatorio!');
            }
        },
        eliminarPostPreguntar(id) {
            Swal.fire({
                title: '¿Estas seguro de eliminar esta publicación?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.EliminarPost(id);
                }
            })
        },
        ocultarDivMegusta(index){
            var div = document.getElementById('divmegusta'+index);
            div.style.display = 'none';
        },
        async EliminarPost(id_publicacion){
            await comunidadService.EliminarPost(id_publicacion).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if (respuesta_ok[1] == 1) {
                    toastr.success(respuesta_ok[0]);
                    this.listarPublicacionPorID();
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        async meGustaPost(id_publicacion){
            var datos = {
                id_usuario: this.datosLogin._id.$oid,
                id_publicacion: id_publicacion
            }
            await comunidadService.meGustaPost(datos).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if (respuesta_ok[1] == 1) {
                    this.listarPublicacionPorID();
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        async likeComentario(id_publicacion, id_comentario){
            var datos = {
                id_publicacion: id_publicacion,
                id_comentario: id_comentario
            }

            await comunidadService.meGustaComentario(datos).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if (respuesta_ok[1] == 1) {
                    comunidadService.infoPost(id_publicacion).then(respuesta => {
                        this.item = respuesta.data;
                    });
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        setIdPublicacionRespuesta(id_publicacion ,item) {
            this.responderActivo = true;
            this.comentarioResponder = item;
            this.padreComentarioResponder = id_publicacion;
        },
        verRespuestas(id){
            $("#"+id).toggle();
        },
        async infoPost(){
            await comunidadService.infoPost(this.selectedPosted).then(respuesta => {
                this.item = respuesta.data;
            });
        },
        eliminarRespuestaPreguntar(id_publicacion, id_comentario){
            Swal.fire({
                title: '¿Estas seguro de eliminar esta respuesta?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.eliminarRespuesta(id_publicacion, id_comentario);
                }
            })
        },
        async eliminarRespuesta(id_publicacion, id_comentario) {
            await comunidadService.eliminarRespuesta(id_comentario).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if (respuesta_ok[1] == 1) {
                    toastr.success(respuesta_ok[0]);
                    comunidadService.infoPost(id_publicacion).then(respuesta => {
                        this.item = respuesta.data;
                    });
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        verModalEditarComentario(id_publicacion, item, tipo){
            this.tipoeditarComentario = tipo;
            this.comentarioSeleccionado = item;
            this.idPublicacionEditarComentario = id_publicacion;
        },
        async guardarEdicionRespuesta(){
            var comentarioTexto = $("#inputComentario001").val();
            var datos = {
                comentarioTexto: comentarioTexto,
                idComentario: this.comentarioSeleccionado._id.$oid
            }

            if (comentarioTexto != "") {
                await comunidadService.editarRespuestaComentario(datos).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    if (respuesta_ok[1] == 1) {
                        $("#inputComentario001").val("");
                        var miDiv = $("#EmojiPicker001");
                        if (miDiv.css("display") === "block") {
                            miDiv.css("display", "none");
                        }
                        toastr.success(respuesta_ok[0]);
                        comunidadService.infoPost(this.idPublicacionEditarComentario).then(respuesta => {
                            this.item = respuesta.data;
                        });

                        $("#modalEditarComentarioP").modal('hide');
                        this.tipoeditarComentario = null;
                        this.comentarioSeleccionado = null;
                        this.idPublicacionEditarComentario = null;                        
                    } else {
                        toastr.error(respuesta_ok[0]);
                    }
                });
                
            } else {
                toastr.warning("¡No ha escrito nada en la caja de comentarios");
            }
        },
        async guardarEdicionComentario(){
            var comentarioTexto = $("#inputComentario001").val();
            var datos = {
                comentarioTexto: comentarioTexto,
                idComentario: this.comentarioSeleccionado._id.$oid,
                idPublicacion: this.idPublicacionEditarComentario
            }

            if (comentarioTexto != "") {
                await comunidadService.editarComentario(datos).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    if (respuesta_ok[1] == 1) {
                        $("#inputComentario001").val("");
                        var miDiv = $("#EmojiPicker001");
                        if (miDiv.css("display") === "block") {
                            miDiv.css("display", "none");
                        }
                        toastr.success(respuesta_ok[0]);
                        comunidadService.infoPost(this.idPublicacionEditarComentario).then(respuesta => {
                            this.item = respuesta.data;
                        });

                        $("#modalEditarComentarioP").modal('hide');
                        this.tipoeditarComentario = null;
                        this.comentarioSeleccionado = null;
                        this.idPublicacionEditarComentario = null;
                        
                    } else {
                        toastr.error(respuesta_ok[0]);
                    }
                });
                
            } else {
                toastr.warning("¡No ha escrito nada en la caja de comentarios");
            }
        }
    }
};
</script>
<style>
.profile-card-with-stats .btn-float {
    padding: 8px 14px 4px 14px;
}

.profile-card-with-cover .card-profile-image {
    position: absolute;
    top: 130px;
    width: 100%;
    text-align: center;
}

.profile-card-with-cover .card-profile-image img.img-border {
    border: 5px solid #fff;
    width: 122px;
    height: 122px;
}

.profile-card-with-cover .profile-card-with-cover-content {
    padding-top: 4rem;
}

#user-profile .profile-with-cover .profil-cover-details {
    position: absolute;
    margin-top: 210px;
}

#user-profile .profile-with-cover .profil-cover-details .profile-image img.img-border {
    border: 5px solid #fff;
}

#user-profile .profile-with-cover .profil-cover-details .card-title {
    color: #fff;
    text-shadow: 1px 1px 4px #1b2942;
}

#user-profile .navbar-profile {
    margin-left: 130px;
}

#users-contacts .delete i,
#users-contacts .favorite i {
    font-size: 1.25rem;
    cursor: pointer;
}

#users-contacts .favorite.active {
    color: #ffa87d;
}

.app-content .sidebar-toggle {
    position: absolute;
    cursor: pointer;
    margin-top: 4px;
}

.app-content .content-overlay {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    position: absolute;
    display: block;
    z-index: 2;
    visibility: hidden;
}

.app-content .content-overlay.show {
    visibility: visible;
    background-color: rgba(0, 0, 0, 0.6);
}

@media only screen and (max-width: 992px) {
    .app-content .bug-list-search form {
        margin-left: 3rem;
    }

    .app-content .sidebar-left {
        transform: translateX(-100%);
        transition: 300ms ease all;
        display: none;
    }

    .app-content .sidebar-left.show {
        display: block;
        position: fixed;
        top: 56px;
        width: 300px;
        z-index: 1036;
        left: 0;
        transform: translateX(0%);
        height: calc(100% - 56px);
        transition: 300ms ease all;
        overflow-y: scroll;
    }

    .app-content .sidebar-left.show .card {
        margin-bottom: 0;
    }
}

.timeline-item {
    list-style: none;
}

.dropzone {
    min-height: 350px;
    border: 2px dashed #808080;
    background: #F5F7FA;
    border-radius: 19px;
}

.miembrosComunidad {
    background-color: #dfdfdf;
    border-radius: 20px;
}

.v3-footer {
    display: none;
}

.comentar {
    color: white;
    background-color: #009199;
    position: absolute;
    right: 0px;
    top: 0px;
    font-size: 1.6em;
    cursor: pointer;
    padding: 9px;
    border-radius: 0px 4px 4px 0px;
}

.burbuja {
    border-radius: 14px;
    padding: 10px;
    background-color: #efefefeb;
    width: 92%;
}


.eliminarcomemntario:hover {
    color: rgb(85, 84, 84);
}

.btn_cerar_modal {
    position: absolute;
    right: 21px;
    top: 22px;
    background-color: #e75252 !important;
    opacity: 1;
    color: white;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    border: 6px solid white !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn_cerar_modal:hover {
    background-color: #d81515 !important;
    color: white !important;
    opacity: 1 !important;
}

.modal-body::-webkit-scrollbar {
    width: 8px !important;
}

.modal-body::-webkit-scrollbar-thumb {
    border-radius: 200px !important;
    background: #a6a3b6 !important;
    border: none !important;
    border-left: 0 !important;
    border-right: 0 !important;
}

.modal-body::-webkit-scrollbar-track {
    background-color: #ffff;
    border-radius: 100px;
}

.insignia {
    position: absolute;
    width: 40px;
    height: 46px;
    top: -10px;
    right: 1px;
    z-index: 1;
}

.opciones_comentario {
    font-size: 28px;
    position: absolute;
    top: 20px;
    z-index: 20;
    right: -122px;
    cursor: pointer;
}

.menu_editar_eliminar::after {
    font-family: "FontAwesome";
    content: "" !important;
    border: none !important;
    position: relative;
    top: 1px;
    right: 0px;
    padding: 0 2px 0 6px;
    margin: 0 0.3em 0 0;
    vertical-align: 0;
}
</style>