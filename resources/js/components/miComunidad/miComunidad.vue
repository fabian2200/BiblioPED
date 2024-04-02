<template lang="">
    <div>
        <div class="row" style="padding-top: 20px; background-image: url('/img/fondo_social.png'); background-size: 100% 780px; background-repeat-y: repeat;">
            <div id="cuerpo_pagina" class="col-12" style="padding-left: 70px; padding-right: 70px">
                <div class="app-content content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div id="user-profile">
                            <div v-if="!loading" class="row">
                                <div class="col-12">
                                    <div class="card profile-with-cover">
                                        <div class="card-img-top img-fluid bg-cover height-300" :style="'background: url('+infoColegio.portada+') 50%;'"></div>
                                        <div class="media profil-cover-details w-100">
                                            <div class="media-left pl-2 pt-2" style="margin-top: 20px">
                                                <a href="#" class="profile-image">
                                                    <img :src="infoColegio.logo" class="rounded-circle img-border height-100" alt="Card image">
                                                </a>
                                            </div>
                                            <div class="media-body pt-4 px-2">
                                                <div class="row">
                                                    <div class="col" style="padding-top: 35px;">
                                                        <h3 style="margin-bottom: 7px; font-size: 1.2rem; color: #009199; font-weight: bold; text-shadow: none" class="card-title titulo_principal">{{infoColegio.nombre}}</h3>
                                                        <h3 style="font-size: 1.2rem;  color: #009199; font-weight: bold; text-shadow: none" class="card-title titulo_principal">Sede - {{infoColegio.sede}}</h3>
                                                    </div>
                                                    <div class="col text-right">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <nav class="navbar navbar-light navbar-profile align-self-end">
                                            <button class="navbar-toggler d-sm-none" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation"></button>
                                            <nav class="navbar navbar-expand-lg">
                                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                                    <ul class="navbar-nav mr-auto">
                                                        <li style="margin-right: 15px" class="nav-item">
                                                            <button type="button" class="btn btn-primary"><i class="feather icon-star"></i> Publicaciones Destacadas</button>
                                                        </li>
                                                        <li class="nav-item active">
                                                            <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modalNewPublicacion"><i class="feather icon-edit"></i> Realizar una publicación <span class="sr-only"></span></button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </nav>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div v-if="!loading">
                                <div id="miembros" style="left: 25px; text-align: center; position: absolute; top: 472px;height: 545px; width: 400px; background-image: url('/img/podio.png'); background-size: 100% 100%" class="miembrosComunidad">
                                    <br>
                                    <h4 style="font-weight: bold; color: #323d51">Usuarios destacados <br> en tu comunidad </h4>
                                    <hr>
                                    <div class="row"  style="margin: 10px;">
                                        <div v-for="(item, index) in usuariosComunidad" :key="index" class="col-xl-4 col-md-6 miembro_box" style="margin-top: 25px; cursor: pointer">
                                            <img class="insignia" v-if="index < 3" :src="'/img/medallas/'+index+'.png'" alt="">
                                            <div class="card profile-card-with-stats" style="border-radius: 13px;">
                                                <div class="text-center">
                                                    <div class="card-body" style="padding: 0;">
                                                        <img :src="'/'+item.imagen" class="rounded-circle height-150" alt="Card image" style="height: 50px !important; margin: 4px;">
                                                    </div>
                                                    <div class="card-body" style="padding: 0.5rem; height: 52px">
                                                        <h4 class="card-title" style="margin-bottom: 6px;font-size: 10px;">{{item.nombre}}</h4>
                                                    </div>
                                                    <div class="btn-group" role="group" aria-label="Profile example" style="margin-bottom: 10px;">
                                                        <button style="padding: 3px; width: 49px;" type="button" class="btn btn-float box-shadow-0 btn-outline-info">
                                                            <span class="ladda-label">
                                                                <i class="fas fa-comments"></i>
                                                                <span style="font-size: 12px;">{{item.numeroIteraciones}}</span>
                                                            </span>
                                                            <span class="ladda-spinner"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">

                                    </div>
                                    <div class="col-lg-8">
                                        <section id="timeline" class="timeline-center timeline-wrapper">
                                            <h3 class="page-title text-center">Últimas publicaciones</h3>
                                            <hr>
                                            <ul v-if="datos.length != 0">                                   
                                                <li v-for="(item, index) in datos" :key="index" class="timeline-item" style="border-radius: 20px; position: relative">
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
                                                                    <img @click="verImagenZoom('/imagenes_comunidad/'+item.imagen)" style="margin-bottom: 20px; cursor: pointer" v-if="item.imagen != ''" class="img-fluid" :src="'/imagenes_comunidad/'+item.imagen" alt="Timeline Image 1">
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
                                                                <div class="card-body">
                                                                    <div v-for="(item2, index2) in item.comentarios" :key="index2">
                                                                        <div class="media media_box_movil" v-if="index2 < 3" style="padding-left: 20px; margin-bottom: 15px">
                                                                            <div class="media-body">
                                                                                <div class="media" style="position: relative">
                                                                                    <div class="media-left mr-1">
                                                                                        <a href="#">
                                                                                            <span class="avatar avatar-online"><img :src="item2.usuario.imagen" alt="avatar"></span>
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
                                                                                            <a class="dropdown-item" href=""  data-toggle="modal" data-target="#modalEditarComentario" @click.prevent="verModalEditarComentario(item._id.$oid, item2, 2, false)"><i class="feather icon-edit-2"></i> Editar</a>
                                                                                            <a class="dropdown-item" type="button" @click="eliminarRespuestaComentarioPregunta(item._id.$oid, item2._id.$oid)"><i class="fas fa-trash-alt"></i> Eliminar</a>
                                                                                        </div>
                                                                                        <ul class="list-inline" style="margin-left: 20px">
                                                                                            <li class="pr-1"><a type="button" @click="likeComentario(item._id.$oid, item2._id.$oid)" class=""><span :class=" item2.like_usuario == 0 ?'fa fa-thumbs-o-up' : 'fa fa-thumbs-up'"></span> ({{item2.likes.length}} Me gusta)</a></li>
                                                                                            <li @click="setIdPublicacionRespuesta(item._id.$oid, item2)" class="pr-1"><a style="font-weight: bold; color: #009c9f; cursor: pointer" type="button" class=""> Responder </a></li>
                                                                                            <li class="pr-1"><strong> {{ item2.fechaFormateada }}</strong></li>
                                                                                            <li style="cursor: pointer" @click="verRespuestas('caja_respuestas_'+item2._id.$oid)" v-if="item2.respuestas_comentario.length > 0" class="pr-1"><strong> {{ item2.respuestas_comentario.length }} Respuesta(s)</strong></li>                                                                                            
                                                                                        </ul>
                                                                                        <ul v-if="item2.respuestas_comentario.length > 0" style="display: none" :id="'caja_respuestas_'+item2._id.$oid">
                                                                                            <div style="display: flex; margin-top: 10px" v-for="(item3, index3) in item2.respuestas_comentario" :key="index" class="media-body">
                                                                                                <div class="media-left mr-1">
                                                                                                    <a href="#">
                                                                                                        <span class="avatar avatar-online"><img :src="item3.usuario.imagen" alt="avatar"></span>
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
                                                                                                            <a class="dropdown-item" href=""  data-toggle="modal" data-target="#modalEditarComentario" @click.prevent="verModalEditarComentario(item._id.$oid, item3, 1, false)"><i class="feather icon-edit-2"></i> Editar</a>
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
                                                                    <a  data-toggle="modal" data-target="#modalPublicacion" @click.prevent="verTodosComentarios(index)" style="margin-left: 30px" href="" v-if="item.comentarios.length > 3">Mostrar todos los comentarios({{ item.comentarios.length - 3 }})</a>
                                                                </div>                                                        
                                                                <div class="card-body" style="padding-top: 0px;">
                                                                    <div :id="'respondiendo_'+item._id.$oid" class="alert alert-success" style="display: none">
                                                                        <p style="margin: 0px">Respondiendo comentario de <strong>{{comentarioResponder.usuario.nombre}}</strong> <strong @click="cancelarResponder" style="color: red; cursor: pointer">Cancelar<a href=""></a></strong></p>
                                                                    </div>
                                                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                                                        <input @click='setIdPublicacion(item._id.$oid, index)' :id="'inputComentario'+index" type="text" class="form-control" placeholder="Escribe tu comentario...">
                                                                        <div style="top: 7px; left: 4px" class="form-control-position">
                                                                            <i @click="mostrarEmojis(index)" style="font-size: 1.6em; cursor: pointer" class="far fa-laugh-beam"></i>
                                                                        </div>
                                                                        <i @click="guardarComentario"  class="comentar fas fa-paper-plane"></i>
                                                                    </fieldset>
                                                                    <div :id="'EmojiPicker'+index" style="position: absolute; position: absolute; bottom: 83px; right: 24px; display: none">
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
                                            <ul v-else>
                                                <div style="text-align:center; border-radius: 10px; background-color: white; width: 100%; height: 700px; display: flex; justify-content: center; align-items: center; flex-direction: column">
                                                    <img style="width: 400px; height: 400px;" src="/img/logo_1_3.png" alt="">
                                                    <h1 style="color: #515151; font-weight: bold;">Aún no hay publicaciones</h1>
                                                </div>
                                            </ul>
                                        </section>
                                    </div>    
                                </div> 
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="modal fade text-left" id="modalPublicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document" v-if="publiSeleccionada != null">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="card-header" style="background-color: #a8dbc4; width: 100%">
                            <div class="media">
                                <div class="media-left mr-1">
                                    <a href="#">
                                        <span class="avatar avatar-md avatar-busy"><img :src="'/'+publiSeleccionada.usuario.imagen" alt="avatar"></span>
                                        <i></i>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="card-title"><a href="#">{{ publiSeleccionada.usuario.nombre }} - <strong v-if="publiSeleccionada.usuario.tipo_registro == 'estudiante'" style="color: #7d7d7d">{{ publiSeleccionada.usuario.grado }}° grado</strong><strong v-if="publiSeleccionada.usuario.tipo_registro == 'docente'" style="color: #7d7d7d">Docente</strong></a></h4>
                                    <p class="card-subtitle text-muted mb-0 pt-1">
                                        <span class="font-small-3">{{ publiSeleccionada.fecha_formateada }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="close btn_cerar_modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 600px; overflow-y: auto; padding-bottom: 7px; overflow-x: hidden">
                        <div class="card-content">
                            <div class="card-body">
                                <p class="card-text" style="font-size: 15px; font-weight: bold; color: rgb(89, 87, 87); line-height: 24px;">{{ publiSeleccionada.detalle }}</p>
                                <img style="margin-bottom: 20px" v-if="publiSeleccionada.imagen != ''" class="img-fluid" :src="'/imagenes_comunidad/'+publiSeleccionada.imagen" alt="Timeline Image 1">
                                <ul class="list-inline">
                                    <li class="pr-1"><a href="#" class=""><span class="fa fa-thumbs-o-up"></span> Me gusta</a></li>
                                    <li class="pr-1"><a href="#" class=""><span class="fa fa-commenting-o"></span> ({{publiSeleccionada.comentarios.length}}) Comentarios</a></li>
                                </ul>
                                <hr>
                            </div>
                        </div> 
                        <div v-for="(item2, index2) in publiSeleccionada.comentarios" :key="index2">
                            <div class="media" style="padding-left: 20px; margin-bottom: 15px">
                                <div class="media-body">
                                    <div class="media" style="position: relative">
                                        <div class="media-left mr-1">
                                            <a href="#">
                                                <span class="avatar avatar-online"><img :src="item2.usuario.imagen" alt="avatar"></span>
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
                                                <a class="dropdown-item" href=""  data-toggle="modal" data-target="#modalEditarComentario" @click.prevent="verModalEditarComentario(publiSeleccionada._id.$oid, item2, 2, true)"><i class="feather icon-edit-2"></i> Editar</a>
                                                <a class="dropdown-item" type="button" @click="eliminarRespuestaComentarioPregunta(publiSeleccionada._id.$oid, item2._id.$oid)"><i class="fas fa-trash-alt"></i> Eliminar</a>
                                            </div>
                                            <ul class="list-inline" style="margin-left: 20px">
                                                <li class="pr-1"><a type="button" @click="likeComentario(publiSeleccionada._id.$oid, item2._id.$oid)" class=""><span :class=" item2.like_usuario == 0 ?'fa fa-thumbs-o-up' : 'fa fa-thumbs-up'"></span> ({{item2.likes.length}} Me gusta)</a></li>
                                                <li @click="setIdPublicacionRespuestaModal(publiSeleccionada._id.$oid, item2)" class="pr-1"><a style="font-weight: bold; color: #009c9f; cursor: pointer" type="button" class=""> Responder </a></li>
                                                <li class="pr-1"><strong> {{ item2.fechaFormateada }}</strong></li>
                                                <li style="cursor: pointer" @click="verRespuestas('caja_respuestas_modal_'+item2._id.$oid)" v-if="item2.respuestas_comentario.length > 0" class="pr-1"><strong> {{ item2.respuestas_comentario.length }} Respuesta(s)</strong></li>                                                                                            
                                            </ul>
                                            <ul style="display: none" v-if="item2.respuestas_comentario.length > 0" :id="'caja_respuestas_modal_'+item2._id.$oid">
                                                <div style="display: flex; margin-top: 10px" v-for="(item3, index3) in item2.respuestas_comentario" :key="index" class="media-body">
                                                    <div class="media-left mr-1">
                                                        <a href="#">
                                                            <span class="avatar avatar-online"><img :src="item3.usuario.imagen" alt="avatar"></span>
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
                                                                <a class="dropdown-item" href=""  data-toggle="modal" data-target="#modalEditarComentario" @click.prevent="verModalEditarComentario(publiSeleccionada._id.$oid, item3, 1, true)"><i class="feather icon-edit-2"></i> Editar</a>
                                                                <button class="dropdown-item" @click="eliminarRespuestaPreguntar(publiSeleccionada._id.$oid, item3._id.$oid)" href="#"><i class="feather icon-trash-2"></i> Eliminar</button>
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
                        <div style="width: 100%; background-color: white; position: sticky; bottom: -7px;">
                            <div class="card-body" style="padding-top: 12px; height: 60px">   
                                <div :id="'respondiendo_modal_'+publiSeleccionada._id.$oid" style="display: none" class="alert alert-success">
                                    <p style="margin: 0px">Respondiendo comentario de <strong>{{comentarioResponder.usuario.nombre}}</strong> <strong @click="cancelarResponderModal" style="color: red; cursor: pointer">Cancelar<a href=""></a></strong></p>
                                </div>                            
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <input @click='setIdPublicacion(publiSeleccionada._id.$oid, indexpubliSeleccionada)' :id="'inputComentario01'" type="text" class="form-control" placeholder="Escribe tu comentario...">
                                    <div style="top: 7px; left: 4px" class="form-control-position">
                                        <i @click="mostrarEmojis('01')" style="font-size: 1.6em; cursor: pointer" class="far fa-laugh-beam"></i>
                                    </div>
                                    <i @click="guardarComentarioModal"  class="comentar fas fa-paper-plane"></i>
                                </fieldset>
                                <div :id="'EmojiPicker01'" style="position: relative; top: -378px; right: -233px; display: none">
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
            </div>
        </div>

        <div class="modal fade text-left" id="modalNewPublicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">Crear publicación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="detallePublicacion"><strong>Detalles de la publicación</strong></label>
                        <textarea v-model="detallePublicacion" rows="6" placeholder="Escribe aquí tu publicación" cols="100" class="form-control" id="detallePublicacion"></textarea>
                        <br>
                        <form style="min-height: 250px; display: flex; align-items: center; justify-content: center;" @click="openFileInputPublicacion" action="#" class="dropzone dropzone-area" id="dpz-single-file">
                            <input type="file" accept="image/*" ref="fileInputPublicacion" style="display: none" @change="handleFileChangePublicacion" />
                            <div v-if="!selectedImage" style="display: flex; align-items: center; justify-content: center; flex-direction: column; width: 70%; height: 200px; text-align: center">
                                <img src="/img/upload_icon.png" width="90" height="75" alt="">
                                <h6 style="color: #808080; margin-top: 10px"><strong>Se admite, JPG, PNG, Gif <br> tamaño máximo 2 MB</strong></h6>
                            </div>
                        </form>
                        <div v-if="selectedImage" style="z-index: 10; position: absolute; top: 47%; left: 14%; display: flex; align-items: center; justify-content: center; width: 70%; height: 200px; text-align: center">
                            <img style="width: 80%; max-height: 100%;" :src="selectedImage" alt="Imagen cargada" />
                            <div class="btn_eliminar"><i @click="eliminarImagenPublicacion" style="color: white" class="fas fa-trash fa-3x"></i></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                        <button type="button" class="btn btn-outline-primary" @click="guardarPublicacion"><i class="fa fa-save"></i> Publicar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="modalEditarPublicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document" v-if="publicacionEditar != null">
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

        <div class="modal fade text-left" id="modalEditarComentario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document" v-if="comentarioSeleccionado != null">
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
                                    <input v-model="comentarioSeleccionado.comentarioTexto" id="inputComentario001" type="text" class="form-control" placeholder="Escribe tu comentario...">
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

        <div @click="scrollToTop" v-if="nuevas_publicaciones" class="alert alert-warning" style="background-color: #0098d0 !important; width: fit-content;position: fixed;top: 92px;z-index: 20000;left: 45%;color: white !important;border-radius: 20px;border: 4px solid white !important;font-weight: bold; cursor: pointer">
            <i class="fas fa-arrow-up"></i> Hay ({{numero_nuevas_publicaciones}}) nuevas publicaciones
        </div>

        <div class="modal fade text-left" id="modImagenZoom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
                <div class="modal-content" style="height: 625px;">
                    <div class="modal-body" style="height: 100%;">
                        <div id='ListEval' style="width: 100%; height: 540px;overflow: auto;text-align: center;display: flex;justify-content: center;align-items: center;">
                            <inner-image-zoom style="height: 500px;" zoomScale="1" :src="rutaSeleccionada" />
                        </div>
                        <div style="text-align: center; margin-top: 10px;">
                            <button @click.prevent="descargarImagenZoom"  type="button" class="btn btn-success"><i class="fas fa-cloud-download-alt"></i> Descargar</button>
                            <button style="margin-left: 20px;" type="button" id="btn_salir" class="btn btn-danger" data-dismiss="modal"><i class="ft-corner-up-left position-right"></i><i class="fas fa-times"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button data-toggle="modal" data-target="#modalNewPublicacion" id="boton_arriba" style="display: none" class="btn btn-warning">
            <i class="fas fa-comments fa-2x" style="font-size: 1.5em"></i>
        </button>
    </div>
</template>
<script>
import * as comunidadService from "../../services/comunidad";
import EmojiPicker from 'vue3-emoji-picker'
import 'vue3-emoji-picker/css'
import * as usuarioService from "../../services/usuario";
import Swal from 'sweetalert2';
import InnerImageZoom from 'vue-inner-image-zoom';
import * as adminService from "../../services/admin";


export default {
    components: {
        EmojiPicker,
        InnerImageZoom
    },
    data() {
        return {
            detallePublicacion: '',
            selectedImage: null,
            imageFile: null,
            pixelesDesplazados: 0,
            datos: [],
            loading: true,
            indexComentario: 0,
            selectedPosted: null,
            datosLogin: null,
            publiSeleccionada: null,
            indexpubliSeleccionada: null,
            colores: [
                '#FFD1DC',
                '#FFCBA4',
                '#E6E6FA',
                '#cce5ff',
                '#b0f2c2',
                '#84b6f4',
                '#fdfd96',
                '#95b8f6',
                '#f79ae5'
            ],
            usuariosComunidad: [],
            publicacionEditar: null,
            detallePublicacionEditar: '',
            selectedImageEditar: null,
            imageFileEditar: null,
            intervalId: null,
            pagina_comentarios: 0,
            numero_post: 0,
            nuevas_publicaciones: false,
            numero_nuevas_publicaciones: 0,
            padreComentarioResponder: 0,
            comentarioResponder: {
                usuario: {
                    nombre: ""
                }
            },
            responderActivo: false,
            comentarioSeleccionado: null,
            tipoeditarComentario: null,
            idPublicacionEditarComentario: null,
            comentarioDesdeModal: false,
            rutaSeleccionada: "",
            infoColegio: null,
        }
    },
    mounted() {
        this.loading = true;
        this.verificarLogin();
        this.infoColegioFunction();
        this.obtenerNumeroPublicaciones();
        if (window.innerWidth > 450) {
            window.addEventListener("scroll", this.actualizarPixelesDesplazados);
        }
        this.misDatos();
        this.listarUsuariosComunidad();
        this.intervalId = setInterval(this.verificarNuevasPublicaciones, 20000);
    },
    beforeDestroy() {
        clearInterval(this.intervalId);
        window.removeEventListener("scroll", this.actualizarPixelesDesplazados);
    },
    methods: {
        misDatos: async function () {
            await usuarioService.misDatos().then(respuesta => {
                this.datosLogin = respuesta.data;
                this.listarPublicaciones();
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
        async infoColegioFunction(){
            await adminService.infoColegio().then(respuesta => {
                this.infoColegio = respuesta.data;
            });
        },
        openFileInputPublicacion() {
            this.$refs.fileInputPublicacion.click();
        },
        handleFileChangePublicacion(event) {
            const file = event.target.files[0];
            this.imageFile = event.target.files[0];
            if (file) {
                this.selectedImage = URL.createObjectURL(file);
            }
        },
        eliminarImagenPublicacion() {
            this.selectedImage = null;
        },
        async guardarPublicacion() {
            const formData = new FormData();
            formData.append('detalle', this.detallePublicacion);
            formData.append('imagen', this.imageFile);

            if (this.detallePublicacion != "") {
                const response = await comunidadService.guardarPublicacion(formData);
                const respuesta_ok = response.data;
                if (respuesta_ok[1] === 1) {
                    toastr.success(respuesta_ok[0]);
                    this.scrollToTop();
                    this.listarUsuariosComunidad();
                } else {
                    toastr.error(respuesta_ok[0]);
                }

                this.detallePublicacion = '';
                this.selectedImage = null;
                this.imageFile = null;
                $("#modalNewPublicacion").modal('hide');
            } else {
                toastr.error('¡El campo detalle de la publicación es obligatorio!');
            }
        },
        actualizarPixelesDesplazados() {
            this.pixelesDesplazados = window.scrollY;
            console.log(this.pixelesDesplazados);
            if (this.pixelesDesplazados >= 461) {
                $('#miembros').css({
                    'position': 'fixed',
                    'top': '11%',
                    'height': '545px',
                    'width': '400px',
                    'left': '80px',
                });

                $('#boton_arriba').css({
                    'position': 'fixed',
                    'bottom': '71px',
                    'right': '12px',
                    'border-radius': '50%',
                    'height': '58px',
                    'width': '58px',
                    'display': 'block',
                });
            } else {
                $('#miembros').css({
                    'position': 'absolute',
                    'top': '472px',
                    'height': '545px',
                    'width': '400px',
                    'left': '25px',
                });

                $('#boton_arriba').css({
                    'display': 'none'
                });
            }

            if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight) {
                this.listarPublicaciones2();
            }
        },
        async listarPublicaciones() {
            this.pagina_comentarios = 1;
            await comunidadService.listarPublicaciones(this.pagina_comentarios).then(respuesta => {
                this.datos = respuesta.data;
                this.loading = false;
            });
        },
        async listarPublicaciones2() {
            this.pagina_comentarios += 1;
            await comunidadService.listarPublicaciones(this.pagina_comentarios).then(respuesta => {
                if(this.pagina_comentarios == 1){
                    this.datos = respuesta.data;
                }else{
                    respuesta.data.forEach(element => {
                        this.datos.push(element);
                    });
                }

                if(respuesta.data.length == 0){
                    this.pagina_comentarios -= 1;
                }
            });
        },
        async listarPublicaciones3() {
            this.obtenerNumeroPublicaciones();
            this.nuevas_publicaciones = false;
            this.pagina_comentarios = 1;
            await comunidadService.listarPublicaciones(this.pagina_comentarios).then(respuesta => {
                this.datos = respuesta.data;
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
                            this.infoPost();
                            this.listarUsuariosComunidad();
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
                            this.cancelarResponder();
                        } else {
                            toastr.error(respuesta_ok[0]);
                        }
                    });
                } else {
                    toastr.warning("¡No ha escrito nada en la caja de comentarios");
                }
            }
        },
        async guardarComentarioModal() {
            if(this.responderActivo == false){
                var comentarioTexto = $("#inputComentario01").val();
                var datos = {
                    comentarioTexto: comentarioTexto,
                    idPost: this.selectedPosted
                }

                if (comentarioTexto != "") {
                    await comunidadService.registrarComentarioPost(datos).then(respuesta => {
                        var respuesta_ok = respuesta.data;
                        if (respuesta_ok[1] == 1) {
                            $("#inputComentario01").val("");
                            var miDiv = $("#EmojiPicker01");
                            if (miDiv.css("display") === "block") {
                                miDiv.css("display", "none");
                            }
                            toastr.success(respuesta_ok[0]);
                            const indiceObjeto = this.datos.findIndex(item => item._id.$oid === this.selectedPosted);
                            comunidadService.infoPost(this.selectedPosted).then(respuesta => {
                                this.datos[indiceObjeto] = respuesta.data;
                                if (this.indexpubliSeleccionada != null) {
                                    this.publiSeleccionada = respuesta.data;
                                }
                            });
                            this.listarUsuariosComunidad();
                        } else {
                            toastr.error(respuesta_ok[0]);
                        }
                    });
                } else {
                    toastr.warning("¡No ha escrito nada en la caja de comentarios");
                }
            }else{
                var comentarioTexto = $("#inputComentario01").val();
                var datos = {
                    comentarioTexto: comentarioTexto,
                    idComentario: this.comentarioResponder._id.$oid,
                    idPublicacion: this.selectedPosted
                }

                if (comentarioTexto != "") {
                    await comunidadService.registrarRespuestaComentarioPost(datos).then(respuesta => {
                        var respuesta_ok = respuesta.data;
                        if (respuesta_ok[1] == 1) {
                            $("#inputComentario01").val("");
                            var miDiv = $("#EmojiPicker01");
                            if (miDiv.css("display") === "block") {
                                miDiv.css("display", "none");
                            }
                            toastr.success(respuesta_ok[0]);
                            const indiceObjeto = this.datos.findIndex(item => item._id.$oid === this.selectedPosted);
                            comunidadService.infoPost(this.selectedPosted).then(respuesta => {
                                this.datos[indiceObjeto] = respuesta.data;
                                if (this.indexpubliSeleccionada != null) {
                                    this.publiSeleccionada = respuesta.data;
                                }
                            });
                            this.cancelarResponderModal();
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
                    const indiceObjeto = this.datos.findIndex(item => item._id.$oid === id_publicacion);
                    comunidadService.infoPost(id_publicacion).then(respuesta => {
                        this.datos[indiceObjeto] = respuesta.data;
                        if (this.indexpubliSeleccionada != null) {
                            this.publiSeleccionada = respuesta.data;
                        }
                    });
                    this.listarUsuariosComunidad();
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        verTodosComentarios(index) {
            this.indexpubliSeleccionada = index;
            this.publiSeleccionada = this.datos[this.indexpubliSeleccionada];
        },
        async listarUsuariosComunidad() {
            await comunidadService.listarUsuariosComunidad().then(respuesta => {
                this.usuariosComunidad = respuesta.data;
                this.loading = false;
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
                    const indiceObjeto = this.datos.findIndex(item => item._id.$oid === this.publicacionEditar._id.$oid);
                    comunidadService.infoPost(this.publicacionEditar._id.$oid).then(respuesta => {
                        this.datos[indiceObjeto] = respuesta.data;
                    });
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
        async EliminarPost(id_publicacion){
            await comunidadService.EliminarPost(id_publicacion).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if (respuesta_ok[1] == 1) {
                    toastr.success(respuesta_ok[0]);
                    this.scrollToTop();
                    this.listarUsuariosComunidad();
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
                    const indiceObjeto = this.datos.findIndex(item => item._id.$oid === id_publicacion);
                    comunidadService.infoPost(id_publicacion).then(respuesta => {
                        this.datos[indiceObjeto] = respuesta.data;
                    });
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        mostrarDivMegusta(index){
            var div = document.getElementById('divmegusta'+index);
            div.style.display = 'block';
        },
        ocultarDivMegusta(index){
            var div = document.getElementById('divmegusta'+index);
            div.style.display = 'none';
        },
        async likeComentario(id_publicacion, id_comentario){
            var datos = {
                id_publicacion: id_publicacion,
                id_comentario: id_comentario
            }

            await comunidadService.meGustaComentario(datos).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if (respuesta_ok[1] == 1) {
                    const indiceObjeto = this.datos.findIndex(item => item._id.$oid === id_publicacion);
                    comunidadService.infoPost(id_publicacion).then(respuesta => {
                        this.datos[indiceObjeto] = respuesta.data;
                        if (this.indexpubliSeleccionada != null) {
                            this.publiSeleccionada = respuesta.data;
                        }
                    });
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        async infoPost(){
            await comunidadService.infoPost(this.selectedPosted).then(respuesta => {
                this.datos[this.indexComentario] = respuesta.data;
            });
        },
        async obtenerNumeroPublicaciones(){
            await comunidadService.obtenerNumeroPublicaciones(this.selectedPosted).then(respuesta => {
                this.numero_post = respuesta.data;
            });
        },
        async verificarNuevasPublicaciones(){
            await comunidadService.obtenerNumeroPublicaciones(this.selectedPosted).then(respuesta => {
                var numero_publicacioens_server = respuesta.data;
                if(numero_publicacioens_server > this.numero_post){
                    this.nuevas_publicaciones = true;
                    this.numero_nuevas_publicaciones = numero_publicacioens_server - this.numero_post; 
                }
            });
        },
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
                duration: 1000
            });

            setTimeout(()=>{
                this.listarPublicaciones3();
            }, 1010);
        },
        setIdPublicacionRespuestaModal(id_publicacion ,item){
            if(this.responderActivo != true){
                this.responderActivo = true;
                this.comentarioResponder = item;
                this.padreComentarioResponder = id_publicacion;
                $("#respondiendo_modal_"+this.padreComentarioResponder).toggle();
            }
        },
        setIdPublicacionRespuesta(id_publicacion ,item) {
            if(this.responderActivo != true){
                this.responderActivo = true;
                this.comentarioResponder = item;
                this.padreComentarioResponder = id_publicacion;
                $("#respondiendo_"+this.padreComentarioResponder).toggle();
            }
        },
        verRespuestas(id){
            $("#"+id).toggle();
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
                    const indiceObjeto = this.datos.findIndex(item => item._id.$oid === id_publicacion);
                    comunidadService.infoPost(id_publicacion).then(respuesta => {
                        this.datos[indiceObjeto] = respuesta.data;
                        if (this.indexpubliSeleccionada != null) {
                            this.publiSeleccionada = respuesta.data;
                        }
                    });
                } else {
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        verModalEditarComentario(id_publicacion, item, tipo, modal){
            this.tipoeditarComentario = tipo;
            this.comentarioSeleccionado = item;
            this.idPublicacionEditarComentario = id_publicacion;
            this.comentarioDesdeModal = modal;

            if(this.comentarioDesdeModal){
                $("#modalPublicacion").modal('hide');
            }
            
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
                        const indiceObjeto = this.datos.findIndex(item => item._id.$oid === this.idPublicacionEditarComentario);
                        comunidadService.infoPost(this.idPublicacionEditarComentario).then(respuesta => {
                            this.datos[indiceObjeto] = respuesta.data;
                            if (this.indexpubliSeleccionada != null) {
                                this.publiSeleccionada = respuesta.data;
                            }
                        });

                        $("#modalEditarComentario").modal('hide');
                        this.tipoeditarComentario = null;
                        this.comentarioSeleccionado = null;
                        this.idPublicacionEditarComentario = null;

                        if(this.comentarioDesdeModal){
                            $("#modalPublicacion").modal('show');
                        }
                        
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
                        const indiceObjeto = this.datos.findIndex(item => item._id.$oid === this.idPublicacionEditarComentario);
                        comunidadService.infoPost(this.idPublicacionEditarComentario).then(respuesta => {
                            this.datos[indiceObjeto] = respuesta.data;
                            if (this.indexpubliSeleccionada != null) {
                                this.publiSeleccionada = respuesta.data;
                            }
                        });

                        $("#modalEditarComentario").modal('hide');
                        this.tipoeditarComentario = null;
                        this.comentarioSeleccionado = null;
                        this.idPublicacionEditarComentario = null;

                        if(this.comentarioDesdeModal){
                            $("#modalPublicacion").modal('show');
                        }
                        
                    } else {
                        toastr.error(respuesta_ok[0]);
                    }
                });
                
            } else {
                toastr.warning("¡No ha escrito nada en la caja de comentarios");
            }
        },
        verImagenZoom(rutaSeleccionada) {
            this.rutaSeleccionada = rutaSeleccionada;
            $("#modImagenZoom").modal("show");
        },
        async descargarImagenZoom() {
            const link = document.createElement('a');
            link.href = this.rutaSeleccionada;
            link.download = "image.png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        cancelarResponder(){
            this.responderActivo = false;
            $("#respondiendo_"+this.padreComentarioResponder).toggle();
        },
        cancelarResponderModal(){
            this.responderActivo = false;
            $("#respondiendo_modal_"+this.padreComentarioResponder).toggle();
        }
    }
};
</script>
<style>
.profile-card-with-stats .btn-float {
    padding: 8px 14px 4px 14px;
}

.iiz__img {
    height: 100% !important;
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

.burbuja2 {
    border-radius: 14px;
    padding: 10px;
    background-color: #efefefeb;
    width: 80%;
}

.eliminarcomemntario {
    position: absolute;
    top: 20px;
    right: -10px;
    font-size: 15px;
    color: gray;
    cursor: pointer;
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

.miDivMegusta {
    display: none;
    padding: 10px;
    background-color: rgb(238, 237, 237);
    border: 1px solid rgb(168, 168, 168);
    position: absolute;
    width: 200px;
    height: auto;
    z-index: 999999999;
    border-radius: 10px;
    color: #404e67;
}

@media (max-width: 450px) {
    #user-profile .profile-with-cover .profil-cover-details {
        position: absolute !important;
        margin-top: 124px !important;
    }

    .titulo_principal {
        text-transform: uppercase;
        font-weight: 500;
        letter-spacing: 0.05rem;
        font-size: 1.12rem;
        color: white !important;
        text-shadow: 2px 0 #000, -1px 0 #000, 0 2px #000, 0 -2px #000, 1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000 !important;
    }

    .pt-4, .py-4 {
        padding-top: 0.5rem !important;
        padding-left: 21px !important;
        font-size: 15px !important;
    }

    #navbarSupportedContent {
        display: flex;
    }

    #user-profile .navbar-profile {
        margin-left: 10px !important; 
    }

    .nav-item button {
        width: 100%;
        margin-bottom: 10px;  
    } 

    .nav-item {
        margin: 0px !important;
    }

    .timeline {
        padding: 0px !important;
    }

    .miembrosComunidad {
        position: initial !important;
        text-align: center;
        height: 738px !important;
        width: 100% !important;
        margin-bottom: 29px;
        background-size: cover;
        background-image: url(/img/podio.png);
    }

    .miembro_box {
        width: 50% !important;
    }

    .letra_publicacion {
        font-size: 13px !important;
        font-weight: bold !important;
        color: rgb(89, 87, 87) !important;
        line-height: 23px !important;
    }

    .media_box_movil {
        padding-left: 0px !important;
    }

    .pr-1 strong {
        font-size: 10px !important;
    }

    .pr-1 {
        font-size: 13px !important;
    }

    .eliminarcomemntario {
        position: absolute !important;
        top: 12px !important;
        right: 26px !important;
        font-size: 12px !important;
        color: gray !important;
        cursor: pointer !important;
    }

    .encabezado_movil {
        font-size: 13px !important;
    }

    .menu_mobil {
        display: block !important;
    }
    
    .opciones_comentario {
        font-size: 28px;
        position: absolute;
        top: -2px !important;
        z-index: 20;
        right: -122px;
        cursor: pointer;
    }
}

@media (max-width: 1024px) {

    #cuerpo_pagina {
        padding-left: 40px !important;
        padding-right: 40px !important;
    }
}

</style>